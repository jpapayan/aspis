<?php require_once('AspisMain.php'); ?><?php
$awaiting_mod = wp_count_comments();
$awaiting_mod = $awaiting_mod->moderated;
$menu[0] = array(__('Dashboard'),'read','index.php','','menu-top','menu-dashboard','div');
$menu[4] = array('','read','separator1','','wp-menu-separator');
$menu[5] = array(__('Posts'),'edit_posts','edit.php','','open-if-no-js menu-top','menu-posts','div');
$submenu['edit.php'][5] = array(__('Edit'),'edit_posts','edit.php');
$submenu['edit.php'][10] = array(_x('Add New','post'),'edit_posts','post-new.php');
$i = 15;
foreach ( $wp_taxonomies as $tax  )
{if ( $tax->hierarchical || !in_array('post',(array)$tax->object_type,true))
 continue ;
$submenu['edit.php'][$i] = array(esc_attr($tax->label),'manage_categories','edit-tags.php?taxonomy=' . $tax->name);
++$i;
}$submenu['edit.php'][50] = array(__('Categories'),'manage_categories','categories.php');
$menu[10] = array(__('Media'),'upload_files','upload.php','','menu-top','menu-media','div');
$submenu['upload.php'][5] = array(__('Library'),'upload_files','upload.php');
$submenu['upload.php'][10] = array(_x('Add New','file'),'upload_files','media-new.php');
$menu[15] = array(__('Links'),'manage_links','link-manager.php','','menu-top','menu-links','div');
$submenu['link-manager.php'][5] = array(__('Edit'),'manage_links','link-manager.php');
$submenu['link-manager.php'][10] = array(_x('Add New','links'),'manage_links','link-add.php');
$submenu['link-manager.php'][15] = array(__('Link Categories'),'manage_categories','edit-link-categories.php');
$menu[20] = array(__('Pages'),'edit_pages','edit-pages.php','','menu-top','menu-pages','div');
$submenu['edit-pages.php'][5] = array(__('Edit'),'edit_pages','edit-pages.php');
$submenu['edit-pages.php'][10] = array(_x('Add New','page'),'edit_pages','page-new.php');
$menu[25] = array(sprintf(__('Comments %s'),"<span id='awaiting-mod' class='count-$awaiting_mod'><span class='pending-count'>" . number_format_i18n($awaiting_mod) . "</span></span>"),'edit_posts','edit-comments.php','','menu-top','menu-comments','div');
$_wp_last_object_menu = 25;
$menu[59] = array('','read','separator2','','wp-menu-separator');
$menu[60] = array(__('Appearance'),'switch_themes','themes.php','','menu-top','menu-appearance','div');
$submenu['themes.php'][5] = array(__('Themes'),'switch_themes','themes.php');
$submenu['themes.php'][10] = array(__('Editor'),'edit_themes','theme-editor.php');
$submenu['themes.php'][15] = array(__('Add New Themes'),'install_themes','theme-install.php');
$update_plugins = get_transient('update_plugins');
$update_count = 0;
if ( !empty($update_plugins->response))
 $update_count = count($update_plugins->response);
$menu[65] = array(sprintf(__('Plugins %s'),"<span class='update-plugins count-$update_count'><span class='plugin-count'>" . number_format_i18n($update_count) . "</span></span>"),'activate_plugins','plugins.php','','menu-top','menu-plugins','div');
$submenu['plugins.php'][5] = array(__('Installed'),'activate_plugins','plugins.php');
$submenu['plugins.php'][10] = array(_x('Add New','plugin'),'install_plugins','plugin-install.php');
$submenu['plugins.php'][15] = array(__('Editor'),'edit_plugins','plugin-editor.php');
if ( current_user_can('edit_users'))
 $menu[70] = array(__('Users'),'edit_users','users.php','','menu-top','menu-users','div');
else 
{$menu[70] = array(__('Profile'),'read','profile.php','','menu-top','menu-users','div');
}if ( current_user_can('edit_users'))
 {$_wp_real_parent_file['profile.php'] = 'users.php';
$submenu['users.php'][5] = array(__('Authors &amp; Users'),'edit_users','users.php');
$submenu['users.php'][10] = array(_x('Add New','user'),'create_users','user-new.php');
$submenu['users.php'][15] = array(__('Your Profile'),'read','profile.php');
}else 
{{$_wp_real_parent_file['users.php'] = 'profile.php';
$submenu['profile.php'][5] = array(__('Your Profile'),'read','profile.php');
}}$menu[75] = array(__('Tools'),'read','tools.php','','menu-top','menu-tools','div');
$submenu['tools.php'][5] = array(__('Tools'),'read','tools.php');
$submenu['tools.php'][10] = array(__('Import'),'import','import.php');
$submenu['tools.php'][15] = array(__('Export'),'import','export.php');
$submenu['tools.php'][20] = array(__('Upgrade'),'install_plugins','update-core.php');
$menu[80] = array(__('Settings'),'manage_options','options-general.php','','menu-top','menu-settings','div');
$submenu['options-general.php'][10] = array(__('General'),'manage_options','options-general.php');
$submenu['options-general.php'][15] = array(__('Writing'),'manage_options','options-writing.php');
$submenu['options-general.php'][20] = array(__('Reading'),'manage_options','options-reading.php');
$submenu['options-general.php'][25] = array(__('Discussion'),'manage_options','options-discussion.php');
$submenu['options-general.php'][30] = array(__('Media'),'manage_options','options-media.php');
$submenu['options-general.php'][35] = array(__('Privacy'),'manage_options','options-privacy.php');
$submenu['options-general.php'][40] = array(__('Permalinks'),'manage_options','options-permalink.php');
$submenu['options-general.php'][45] = array(__('Miscellaneous'),'manage_options','options-misc.php');
$_wp_last_utility_menu = 80;
$menu[99] = array('','read','separator-last','','wp-menu-separator-last');
$_wp_real_parent_file['post.php'] = 'edit.php';
$_wp_real_parent_file['post-new.php'] = 'edit.php';
$_wp_real_parent_file['page-new.php'] = 'edit-pages.php';
do_action('_admin_menu');
foreach ( $menu as $menu_page  )
{$hook_name = sanitize_title(basename($menu_page[2],'.php'));
$compat = array('index' => 'dashboard','edit' => 'posts','upload' => 'media','link-manager' => 'links','edit-pages' => 'pages','edit-comments' => 'comments','options-general' => 'settings','themes' => 'appearance',);
if ( isset($compat[$hook_name]))
 $hook_name = $compat[$hook_name];
elseif ( !$hook_name)
 continue ;
$admin_page_hooks[$menu_page[2]] = $hook_name;
}$_wp_submenu_nopriv = array();
$_wp_menu_nopriv = array();
foreach ( array('submenu') as $sub_loop  )
{foreach ( $$sub_loop as $parent =>$sub )
{foreach ( $sub as $index =>$data )
{if ( !current_user_can($data[1]))
 {unset(${$sub_loop}[$parent][$index]);
$_wp_submenu_nopriv[$parent][$data[2]] = true;
}}if ( empty(${$sub_loop}[$parent]))
 unset(${$sub_loop}[$parent]);
}}foreach ( $menu as $id =>$data )
{if ( empty($submenu[$data[2]]))
 continue ;
$subs = $submenu[$data[2]];
$first_sub = array_shift($subs);
$old_parent = $data[2];
$new_parent = $first_sub[2];
if ( $new_parent != $old_parent)
 {$_wp_real_parent_file[$old_parent] = $new_parent;
$menu[$id][2] = $new_parent;
foreach ( $submenu[$old_parent] as $index =>$data )
{$submenu[$new_parent][$index] = $submenu[$old_parent][$index];
unset($submenu[$old_parent][$index]);
}unset($submenu[$old_parent]);
if ( isset($_wp_submenu_nopriv[$old_parent]))
 $_wp_submenu_nopriv[$new_parent] = $_wp_submenu_nopriv[$old_parent];
}}do_action('admin_menu','');
foreach ( $menu as $id =>$data )
{if ( !current_user_can($data[1]))
 $_wp_menu_nopriv[$data[2]] = true;
if ( empty($submenu[$data[2]]))
 {if ( isset($_wp_menu_nopriv[$data[2]]))
 {unset($menu[$id]);
}}}$seperator_found = false;
foreach ( $menu as $id =>$data )
{if ( 0 == strcmp('wp-menu-separator',$data[4]))
 {if ( false == $seperator_found)
 {$seperator_found = true;
}else 
{{unset($menu[$id]);
$seperator_found = false;
}}}else 
{{$seperator_found = false;
}}}unset($id);
function add_cssclass ( $add,$class ) {
$class = empty($class) ? $add : $class .= ' ' . $add;
{$AspisRetTemp = $class;
return $AspisRetTemp;
} }
function add_menu_classes ( $menu ) {
$first = $lastorder = false;
$i = 0;
$mc = count($menu);
foreach ( $menu as $order =>$top )
{$i++;
if ( 0 == $order)
 {$menu[0][4] = add_cssclass('menu-top-first',$top[4]);
$lastorder = 0;
continue ;
}if ( 0 === strpos($top[2],'separator'))
 {$first = true;
$c = $menu[$lastorder][4];
$menu[$lastorder][4] = add_cssclass('menu-top-last',$c);
continue ;
}if ( $first)
 {$c = $menu[$order][4];
$menu[$order][4] = add_cssclass('menu-top-first',$c);
$first = false;
}if ( $mc == $i)
 {$c = $menu[$order][4];
$menu[$order][4] = add_cssclass('menu-top-last',$c);
}$lastorder = $order;
}{$AspisRetTemp = apply_filters('add_menu_classes',$menu);
return $AspisRetTemp;
} }
uksort($menu,"strnatcasecmp");
if ( apply_filters('custom_menu_order',false))
 {$menu_order = array();
foreach ( $menu as $menu_item  )
{$menu_order[] = $menu_item[2];
}unset($menu_item);
$default_menu_order = $menu_order;
$menu_order = apply_filters('menu_order',$menu_order);
$menu_order = array_flip($menu_order);
$default_menu_order = array_flip($default_menu_order);
function sort_menu ( $a,$b ) {
{global $menu_order,$default_menu_order;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $menu_order,"\$menu_order",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($default_menu_order,"\$default_menu_order",$AspisChangesCache);
}$a = $a[2];
$b = $b[2];
if ( isset($menu_order[$a]) && !isset($menu_order[$b]))
 {{$AspisRetTemp = -1;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$menu_order",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$default_menu_order",$AspisChangesCache);
return $AspisRetTemp;
}}elseif ( !isset($menu_order[$a]) && isset($menu_order[$b]))
 {{$AspisRetTemp = 1;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$menu_order",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$default_menu_order",$AspisChangesCache);
return $AspisRetTemp;
}}elseif ( isset($menu_order[$a]) && isset($menu_order[$b]))
 {if ( $menu_order[$a] == $menu_order[$b])
 {$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$menu_order",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$default_menu_order",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = ($menu_order[$a] < $menu_order[$b]) ? -1 : 1;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$menu_order",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$default_menu_order",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = ($default_menu_order[$a] <= $default_menu_order[$b]) ? -1 : 1;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$menu_order",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$default_menu_order",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$menu_order",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$default_menu_order",$AspisChangesCache);
 }
AspisUntainted_usort($menu,'sort_menu');
unset($menu_order,$default_menu_order);
}$menu = add_menu_classes($menu);
if ( !user_can_access_admin_page())
 {do_action('admin_page_access_denied');
wp_die(__('You do not have sufficient permissions to access this page.'));
};
?>
<?php 