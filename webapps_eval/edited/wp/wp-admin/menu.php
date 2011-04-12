<?php require_once('AspisMain.php'); ?><?php
$awaiting_mod = wp_count_comments();
$awaiting_mod = $awaiting_mod[0]->moderated;
arrayAssign($menu[0],deAspis(registerTaint(array(0,false))),addTaint(array(array(__(array('Dashboard',false)),array('read',false),array('index.php',false),array('',false),array('menu-top',false),array('menu-dashboard',false),array('div',false)),false)));
arrayAssign($menu[0],deAspis(registerTaint(array(4,false))),addTaint(array(array(array('',false),array('read',false),array('separator1',false),array('',false),array('wp-menu-separator',false)),false)));
arrayAssign($menu[0],deAspis(registerTaint(array(5,false))),addTaint(array(array(__(array('Posts',false)),array('edit_posts',false),array('edit.php',false),array('',false),array('open-if-no-js menu-top',false),array('menu-posts',false),array('div',false)),false)));
arrayAssign($submenu[0][('edit.php')][0],deAspis(registerTaint(array(5,false))),addTaint(array(array(__(array('Edit',false)),array('edit_posts',false),array('edit.php',false)),false)));
arrayAssign($submenu[0][('edit.php')][0],deAspis(registerTaint(array(10,false))),addTaint(array(array(_x(array('Add New',false),array('post',false)),array('edit_posts',false),array('post-new.php',false)),false)));
$i = array(15,false);
foreach ( $wp_taxonomies[0] as $tax  )
{if ( ($tax[0]->hierarchical[0] || (denot_boolean(Aspis_in_array(array('post',false),array_cast($tax[0]->object_type),array(true,false))))))
 continue ;
arrayAssign($submenu[0][('edit.php')][0],deAspis(registerTaint($i)),addTaint(array(array(esc_attr($tax[0]->label),array('manage_categories',false),concat1('edit-tags.php?taxonomy=',$tax[0]->name)),false)));
preincr($i);
}arrayAssign($submenu[0][('edit.php')][0],deAspis(registerTaint(array(50,false))),addTaint(array(array(__(array('Categories',false)),array('manage_categories',false),array('categories.php',false)),false)));
arrayAssign($menu[0],deAspis(registerTaint(array(10,false))),addTaint(array(array(__(array('Media',false)),array('upload_files',false),array('upload.php',false),array('',false),array('menu-top',false),array('menu-media',false),array('div',false)),false)));
arrayAssign($submenu[0][('upload.php')][0],deAspis(registerTaint(array(5,false))),addTaint(array(array(__(array('Library',false)),array('upload_files',false),array('upload.php',false)),false)));
arrayAssign($submenu[0][('upload.php')][0],deAspis(registerTaint(array(10,false))),addTaint(array(array(_x(array('Add New',false),array('file',false)),array('upload_files',false),array('media-new.php',false)),false)));
arrayAssign($menu[0],deAspis(registerTaint(array(15,false))),addTaint(array(array(__(array('Links',false)),array('manage_links',false),array('link-manager.php',false),array('',false),array('menu-top',false),array('menu-links',false),array('div',false)),false)));
arrayAssign($submenu[0][('link-manager.php')][0],deAspis(registerTaint(array(5,false))),addTaint(array(array(__(array('Edit',false)),array('manage_links',false),array('link-manager.php',false)),false)));
arrayAssign($submenu[0][('link-manager.php')][0],deAspis(registerTaint(array(10,false))),addTaint(array(array(_x(array('Add New',false),array('links',false)),array('manage_links',false),array('link-add.php',false)),false)));
arrayAssign($submenu[0][('link-manager.php')][0],deAspis(registerTaint(array(15,false))),addTaint(array(array(__(array('Link Categories',false)),array('manage_categories',false),array('edit-link-categories.php',false)),false)));
arrayAssign($menu[0],deAspis(registerTaint(array(20,false))),addTaint(array(array(__(array('Pages',false)),array('edit_pages',false),array('edit-pages.php',false),array('',false),array('menu-top',false),array('menu-pages',false),array('div',false)),false)));
arrayAssign($submenu[0][('edit-pages.php')][0],deAspis(registerTaint(array(5,false))),addTaint(array(array(__(array('Edit',false)),array('edit_pages',false),array('edit-pages.php',false)),false)));
arrayAssign($submenu[0][('edit-pages.php')][0],deAspis(registerTaint(array(10,false))),addTaint(array(array(_x(array('Add New',false),array('page',false)),array('edit_pages',false),array('page-new.php',false)),false)));
arrayAssign($menu[0],deAspis(registerTaint(array(25,false))),addTaint(array(array(Aspis_sprintf(__(array('Comments %s',false)),concat2(concat(concat2(concat1("<span id='awaiting-mod' class='count-",$awaiting_mod),"'><span class='pending-count'>"),number_format_i18n($awaiting_mod)),"</span></span>")),array('edit_posts',false),array('edit-comments.php',false),array('',false),array('menu-top',false),array('menu-comments',false),array('div',false)),false)));
$_wp_last_object_menu = array(25,false);
arrayAssign($menu[0],deAspis(registerTaint(array(59,false))),addTaint(array(array(array('',false),array('read',false),array('separator2',false),array('',false),array('wp-menu-separator',false)),false)));
arrayAssign($menu[0],deAspis(registerTaint(array(60,false))),addTaint(array(array(__(array('Appearance',false)),array('switch_themes',false),array('themes.php',false),array('',false),array('menu-top',false),array('menu-appearance',false),array('div',false)),false)));
arrayAssign($submenu[0][('themes.php')][0],deAspis(registerTaint(array(5,false))),addTaint(array(array(__(array('Themes',false)),array('switch_themes',false),array('themes.php',false)),false)));
arrayAssign($submenu[0][('themes.php')][0],deAspis(registerTaint(array(10,false))),addTaint(array(array(__(array('Editor',false)),array('edit_themes',false),array('theme-editor.php',false)),false)));
arrayAssign($submenu[0][('themes.php')][0],deAspis(registerTaint(array(15,false))),addTaint(array(array(__(array('Add New Themes',false)),array('install_themes',false),array('theme-install.php',false)),false)));
$update_plugins = get_transient(array('update_plugins',false));
$update_count = array(0,false);
if ( (!((empty($update_plugins[0]->response) || Aspis_empty( $update_plugins[0] ->response )))))
 $update_count = attAspis(count($update_plugins[0]->response[0]));
arrayAssign($menu[0],deAspis(registerTaint(array(65,false))),addTaint(array(array(Aspis_sprintf(__(array('Plugins %s',false)),concat2(concat(concat2(concat1("<span class='update-plugins count-",$update_count),"'><span class='plugin-count'>"),number_format_i18n($update_count)),"</span></span>")),array('activate_plugins',false),array('plugins.php',false),array('',false),array('menu-top',false),array('menu-plugins',false),array('div',false)),false)));
arrayAssign($submenu[0][('plugins.php')][0],deAspis(registerTaint(array(5,false))),addTaint(array(array(__(array('Installed',false)),array('activate_plugins',false),array('plugins.php',false)),false)));
arrayAssign($submenu[0][('plugins.php')][0],deAspis(registerTaint(array(10,false))),addTaint(array(array(_x(array('Add New',false),array('plugin',false)),array('install_plugins',false),array('plugin-install.php',false)),false)));
arrayAssign($submenu[0][('plugins.php')][0],deAspis(registerTaint(array(15,false))),addTaint(array(array(__(array('Editor',false)),array('edit_plugins',false),array('plugin-editor.php',false)),false)));
if ( deAspis(current_user_can(array('edit_users',false))))
 arrayAssign($menu[0],deAspis(registerTaint(array(70,false))),addTaint(array(array(__(array('Users',false)),array('edit_users',false),array('users.php',false),array('',false),array('menu-top',false),array('menu-users',false),array('div',false)),false)));
else 
{arrayAssign($menu[0],deAspis(registerTaint(array(70,false))),addTaint(array(array(__(array('Profile',false)),array('read',false),array('profile.php',false),array('',false),array('menu-top',false),array('menu-users',false),array('div',false)),false)));
}if ( deAspis(current_user_can(array('edit_users',false))))
 {arrayAssign($_wp_real_parent_file[0],deAspis(registerTaint(array('profile.php',false))),addTaint(array('users.php',false)));
arrayAssign($submenu[0][('users.php')][0],deAspis(registerTaint(array(5,false))),addTaint(array(array(__(array('Authors &amp; Users',false)),array('edit_users',false),array('users.php',false)),false)));
arrayAssign($submenu[0][('users.php')][0],deAspis(registerTaint(array(10,false))),addTaint(array(array(_x(array('Add New',false),array('user',false)),array('create_users',false),array('user-new.php',false)),false)));
arrayAssign($submenu[0][('users.php')][0],deAspis(registerTaint(array(15,false))),addTaint(array(array(__(array('Your Profile',false)),array('read',false),array('profile.php',false)),false)));
}else 
{{arrayAssign($_wp_real_parent_file[0],deAspis(registerTaint(array('users.php',false))),addTaint(array('profile.php',false)));
arrayAssign($submenu[0][('profile.php')][0],deAspis(registerTaint(array(5,false))),addTaint(array(array(__(array('Your Profile',false)),array('read',false),array('profile.php',false)),false)));
}}arrayAssign($menu[0],deAspis(registerTaint(array(75,false))),addTaint(array(array(__(array('Tools',false)),array('read',false),array('tools.php',false),array('',false),array('menu-top',false),array('menu-tools',false),array('div',false)),false)));
arrayAssign($submenu[0][('tools.php')][0],deAspis(registerTaint(array(5,false))),addTaint(array(array(__(array('Tools',false)),array('read',false),array('tools.php',false)),false)));
arrayAssign($submenu[0][('tools.php')][0],deAspis(registerTaint(array(10,false))),addTaint(array(array(__(array('Import',false)),array('import',false),array('import.php',false)),false)));
arrayAssign($submenu[0][('tools.php')][0],deAspis(registerTaint(array(15,false))),addTaint(array(array(__(array('Export',false)),array('import',false),array('export.php',false)),false)));
arrayAssign($submenu[0][('tools.php')][0],deAspis(registerTaint(array(20,false))),addTaint(array(array(__(array('Upgrade',false)),array('install_plugins',false),array('update-core.php',false)),false)));
arrayAssign($menu[0],deAspis(registerTaint(array(80,false))),addTaint(array(array(__(array('Settings',false)),array('manage_options',false),array('options-general.php',false),array('',false),array('menu-top',false),array('menu-settings',false),array('div',false)),false)));
arrayAssign($submenu[0][('options-general.php')][0],deAspis(registerTaint(array(10,false))),addTaint(array(array(__(array('General',false)),array('manage_options',false),array('options-general.php',false)),false)));
arrayAssign($submenu[0][('options-general.php')][0],deAspis(registerTaint(array(15,false))),addTaint(array(array(__(array('Writing',false)),array('manage_options',false),array('options-writing.php',false)),false)));
arrayAssign($submenu[0][('options-general.php')][0],deAspis(registerTaint(array(20,false))),addTaint(array(array(__(array('Reading',false)),array('manage_options',false),array('options-reading.php',false)),false)));
arrayAssign($submenu[0][('options-general.php')][0],deAspis(registerTaint(array(25,false))),addTaint(array(array(__(array('Discussion',false)),array('manage_options',false),array('options-discussion.php',false)),false)));
arrayAssign($submenu[0][('options-general.php')][0],deAspis(registerTaint(array(30,false))),addTaint(array(array(__(array('Media',false)),array('manage_options',false),array('options-media.php',false)),false)));
arrayAssign($submenu[0][('options-general.php')][0],deAspis(registerTaint(array(35,false))),addTaint(array(array(__(array('Privacy',false)),array('manage_options',false),array('options-privacy.php',false)),false)));
arrayAssign($submenu[0][('options-general.php')][0],deAspis(registerTaint(array(40,false))),addTaint(array(array(__(array('Permalinks',false)),array('manage_options',false),array('options-permalink.php',false)),false)));
arrayAssign($submenu[0][('options-general.php')][0],deAspis(registerTaint(array(45,false))),addTaint(array(array(__(array('Miscellaneous',false)),array('manage_options',false),array('options-misc.php',false)),false)));
$_wp_last_utility_menu = array(80,false);
arrayAssign($menu[0],deAspis(registerTaint(array(99,false))),addTaint(array(array(array('',false),array('read',false),array('separator-last',false),array('',false),array('wp-menu-separator-last',false)),false)));
arrayAssign($_wp_real_parent_file[0],deAspis(registerTaint(array('post.php',false))),addTaint(array('edit.php',false)));
arrayAssign($_wp_real_parent_file[0],deAspis(registerTaint(array('post-new.php',false))),addTaint(array('edit.php',false)));
arrayAssign($_wp_real_parent_file[0],deAspis(registerTaint(array('page-new.php',false))),addTaint(array('edit-pages.php',false)));
do_action(array('_admin_menu',false));
foreach ( $menu[0] as $menu_page  )
{$hook_name = sanitize_title(Aspis_basename(attachAspis($menu_page,(2)),array('.php',false)));
$compat = array(array('index' => array('dashboard',false,false),'edit' => array('posts',false,false),'upload' => array('media',false,false),'link-manager' => array('links',false,false),'edit-pages' => array('pages',false,false),'edit-comments' => array('comments',false,false),'options-general' => array('settings',false,false),'themes' => array('appearance',false,false),),false);
if ( ((isset($compat[0][$hook_name[0]]) && Aspis_isset( $compat [0][$hook_name[0]]))))
 $hook_name = attachAspis($compat,$hook_name[0]);
elseif ( (denot_boolean($hook_name)))
 continue ;
arrayAssign($admin_page_hooks[0],deAspis(registerTaint(attachAspis($menu_page,(2)))),addTaint($hook_name));
}$_wp_submenu_nopriv = array(array(),false);
$_wp_menu_nopriv = array(array(),false);
foreach ( (array(array('submenu',false))) as $sub_loop  )
{foreach ( deAspis(${$sub_loop[0]}) as $parent =>$sub )
{restoreTaint($parent,$sub);
{foreach ( $sub[0] as $index =>$data )
{restoreTaint($index,$data);
{if ( (denot_boolean(current_user_can(attachAspis($data,(1))))))
 {unset(${$sub_loop[0]}[0][$parent[0]][0][$index[0]]);
arrayAssign($_wp_submenu_nopriv[0][$parent[0]][0],deAspis(registerTaint(attachAspis($data,(2)))),addTaint(array(true,false)));
}}}if ( ((empty(${$sub_loop[0]}[0][$parent[0]]) || Aspis_empty( ${ $sub_loop[0]} [0][$parent[0]]))))
 unset(${$sub_loop[0]}[0][$parent[0]]);
}}}foreach ( $menu[0] as $id =>$data )
{restoreTaint($id,$data);
{if ( ((empty($submenu[0][deAspis(attachAspis($data,(2)))]) || Aspis_empty( $submenu [0][deAspis(attachAspis( $data ,(2)))]))))
 continue ;
$subs = attachAspis($submenu,deAspis(attachAspis($data,(2))));
$first_sub = Aspis_array_shift($subs);
$old_parent = attachAspis($data,(2));
$new_parent = attachAspis($first_sub,(2));
if ( ($new_parent[0] != $old_parent[0]))
 {arrayAssign($_wp_real_parent_file[0],deAspis(registerTaint($old_parent)),addTaint($new_parent));
arrayAssign($menu[0][$id[0]][0],deAspis(registerTaint(array(2,false))),addTaint($new_parent));
foreach ( deAspis(attachAspis($submenu,$old_parent[0])) as $index =>$data )
{restoreTaint($index,$data);
{arrayAssign($submenu[0][$new_parent[0]][0],deAspis(registerTaint($index)),addTaint(attachAspis($submenu[0][$old_parent[0]],$index[0])));
unset($submenu[0][$old_parent[0]][0][$index[0]]);
}}unset($submenu[0][$old_parent[0]]);
if ( ((isset($_wp_submenu_nopriv[0][$old_parent[0]]) && Aspis_isset( $_wp_submenu_nopriv [0][$old_parent[0]]))))
 arrayAssign($_wp_submenu_nopriv[0],deAspis(registerTaint($new_parent)),addTaint(attachAspis($_wp_submenu_nopriv,$old_parent[0])));
}}}do_action(array('admin_menu',false),array('',false));
foreach ( $menu[0] as $id =>$data )
{restoreTaint($id,$data);
{if ( (denot_boolean(current_user_can(attachAspis($data,(1))))))
 arrayAssign($_wp_menu_nopriv[0],deAspis(registerTaint(attachAspis($data,(2)))),addTaint(array(true,false)));
if ( ((empty($submenu[0][deAspis(attachAspis($data,(2)))]) || Aspis_empty( $submenu [0][deAspis(attachAspis( $data ,(2)))]))))
 {if ( ((isset($_wp_menu_nopriv[0][deAspis(attachAspis($data,(2)))]) && Aspis_isset( $_wp_menu_nopriv [0][deAspis(attachAspis( $data ,(2)))]))))
 {unset($menu[0][$id[0]]);
}}}}$seperator_found = array(false,false);
foreach ( $menu[0] as $id =>$data )
{restoreTaint($id,$data);
{if ( ((0) == strcmp(('wp-menu-separator'),deAspis(attachAspis($data,(4))))))
 {if ( (false == $seperator_found[0]))
 {$seperator_found = array(true,false);
}else 
{{unset($menu[0][$id[0]]);
$seperator_found = array(false,false);
}}}else 
{{$seperator_found = array(false,false);
}}}}unset($id);
function add_cssclass ( $add,$class ) {
$class = ((empty($class) || Aspis_empty( $class))) ? $add : $class = concat($class,concat1(' ',$add));
return $class;
 }
function add_menu_classes ( $menu ) {
$first = $lastorder = array(false,false);
$i = array(0,false);
$mc = attAspis(count($menu[0]));
foreach ( $menu[0] as $order =>$top )
{restoreTaint($order,$top);
{postincr($i);
if ( ((0) == $order[0]))
 {arrayAssign($menu[0][(0)][0],deAspis(registerTaint(array(4,false))),addTaint(add_cssclass(array('menu-top-first',false),attachAspis($top,(4)))));
$lastorder = array(0,false);
continue ;
}if ( ((0) === strpos(deAspis(attachAspis($top,(2))),'separator')))
 {$first = array(true,false);
$c = attachAspis($menu[0][$lastorder[0]],(4));
arrayAssign($menu[0][$lastorder[0]][0],deAspis(registerTaint(array(4,false))),addTaint(add_cssclass(array('menu-top-last',false),$c)));
continue ;
}if ( $first[0])
 {$c = attachAspis($menu[0][$order[0]],(4));
arrayAssign($menu[0][$order[0]][0],deAspis(registerTaint(array(4,false))),addTaint(add_cssclass(array('menu-top-first',false),$c)));
$first = array(false,false);
}if ( ($mc[0] == $i[0]))
 {$c = attachAspis($menu[0][$order[0]],(4));
arrayAssign($menu[0][$order[0]][0],deAspis(registerTaint(array(4,false))),addTaint(add_cssclass(array('menu-top-last',false),$c)));
}$lastorder = $order;
}}return apply_filters(array('add_menu_classes',false),$menu);
 }
AspisInternalFunctionCall("uksort",AspisPushRefParam($menu),AspisInternalCallback(array("strnatcasecmp",false)),array(0));
if ( deAspis(apply_filters(array('custom_menu_order',false),array(false,false))))
 {$menu_order = array(array(),false);
foreach ( $menu[0] as $menu_item  )
{arrayAssignAdd($menu_order[0][],addTaint(attachAspis($menu_item,(2))));
}unset($menu_item);
$default_menu_order = $menu_order;
$menu_order = apply_filters(array('menu_order',false),$menu_order);
$menu_order = Aspis_array_flip($menu_order);
$default_menu_order = Aspis_array_flip($default_menu_order);
function sort_menu ( $a,$b ) {
global $menu_order,$default_menu_order;
$a = attachAspis($a,(2));
$b = attachAspis($b,(2));
if ( (((isset($menu_order[0][$a[0]]) && Aspis_isset( $menu_order [0][$a[0]]))) && (!((isset($menu_order[0][$b[0]]) && Aspis_isset( $menu_order [0][$b[0]]))))))
 {return negate(array(1,false));
}elseif ( ((!((isset($menu_order[0][$a[0]]) && Aspis_isset( $menu_order [0][$a[0]])))) && ((isset($menu_order[0][$b[0]]) && Aspis_isset( $menu_order [0][$b[0]])))))
 {return array(1,false);
}elseif ( (((isset($menu_order[0][$a[0]]) && Aspis_isset( $menu_order [0][$a[0]]))) && ((isset($menu_order[0][$b[0]]) && Aspis_isset( $menu_order [0][$b[0]])))))
 {if ( (deAspis(attachAspis($menu_order,$a[0])) == deAspis(attachAspis($menu_order,$b[0]))))
 return array(0,false);
return (deAspis(attachAspis($menu_order,$a[0])) < deAspis(attachAspis($menu_order,$b[0]))) ? negate(array(1,false)) : array(1,false);
}else 
{{return (deAspis(attachAspis($default_menu_order,$a[0])) <= deAspis(attachAspis($default_menu_order,$b[0]))) ? negate(array(1,false)) : array(1,false);
}} }
Aspis_usort($menu,array('sort_menu',false));
unset($menu_order,$default_menu_order);
}$menu = add_menu_classes($menu);
if ( (denot_boolean(user_can_access_admin_page())))
 {do_action(array('admin_page_access_denied',false));
wp_die(__(array('You do not have sufficient permissions to access this page.',false)));
};
?>
<?php 