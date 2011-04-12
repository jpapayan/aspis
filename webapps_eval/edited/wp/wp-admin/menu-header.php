<?php require_once('AspisMain.php'); ?><?php
$self = Aspis_preg_replace(array('|^.*/wp-admin/|i',false),array('',false),$_SERVER[0]['PHP_SELF']);
$self = Aspis_preg_replace(array('|^.*/plugins/|i',false),array('',false),$self);
global $menu,$submenu,$parent_file;
get_admin_page_parent();
function _wp_menu_output ( $menu,$submenu,$submenu_as_parent = array(true,false) ) {
global $self,$parent_file,$submenu_file,$plugin_page,$pagenow;
$first = array(true,false);
foreach ( $menu[0] as $key =>$item )
{restoreTaint($key,$item);
{$admin_is_parent = array(false,false);
$class = array(array(),false);
if ( $first[0])
 {arrayAssignAdd($class[0][],addTaint(array('wp-first-item',false)));
$first = array(false,false);
}if ( (!((empty($submenu[0][deAspis(attachAspis($item,(2)))]) || Aspis_empty( $submenu [0][deAspis(attachAspis( $item ,(2)))])))))
 arrayAssignAdd($class[0][],addTaint(array('wp-has-submenu',false)));
if ( (($parent_file[0] && (deAspis(attachAspis($item,(2))) == $parent_file[0])) || (strcmp($self[0],deAspis(attachAspis($item,(2)))) == (0))))
 {if ( (!((empty($submenu[0][deAspis(attachAspis($item,(2)))]) || Aspis_empty( $submenu [0][deAspis(attachAspis( $item ,(2)))])))))
 arrayAssignAdd($class[0][],addTaint(array('wp-has-current-submenu wp-menu-open',false)));
else 
{arrayAssignAdd($class[0][],addTaint(array('current',false)));
}}if ( (((isset($item[0][(4)]) && Aspis_isset( $item [0][(4)]))) && (!((empty($item[0][(4)]) || Aspis_empty( $item [0][(4)]))))))
 arrayAssignAdd($class[0][],addTaint(attachAspis($item,(4))));
$class = $class[0] ? concat2(concat1(' class="',Aspis_join(array(' ',false),$class)),'"') : array('',false);
$tabindex = array(' tabindex="1"',false);
$id = (((isset($item[0][(5)]) && Aspis_isset( $item [0][(5)]))) && (!((empty($item[0][(5)]) || Aspis_empty( $item [0][(5)]))))) ? concat2(concat1(' id="',Aspis_preg_replace(array('|[^a-zA-Z0-9_:.]|',false),array('-',false),attachAspis($item,(5)))),'"') : array('',false);
$img = array('',false);
if ( (((isset($item[0][(6)]) && Aspis_isset( $item [0][(6)]))) && (!((empty($item[0][(6)]) || Aspis_empty( $item [0][(6)]))))))
 {if ( (('div') === deAspis(attachAspis($item,(6)))))
 $img = array('<br />',false);
else 
{$img = concat2(concat1('<img src="',attachAspis($item,(6))),'" alt="" />');
}}$toggle = array('<div class="wp-menu-toggle"><br /></div>',false);
echo AspisCheckPrint(concat2(concat(concat1("\n\t<li",$class),$id),">"));
if ( (false !== strpos($class[0],'wp-menu-separator')))
 {echo AspisCheckPrint(array('<a class="separator" href="?unfoldmenu=1"><br /></a>',false));
}elseif ( ($submenu_as_parent[0] && (!((empty($submenu[0][deAspis(attachAspis($item,(2)))]) || Aspis_empty( $submenu [0][deAspis(attachAspis( $item ,(2)))]))))))
 {arrayAssign($submenu[0],deAspis(registerTaint(attachAspis($item,(2)))),addTaint(Aspis_array_values(attachAspis($submenu,deAspis(attachAspis($item,(2)))))));
$menu_hook = get_plugin_page_hook(attachAspis($submenu[0][deAspis(attachAspis($item,(2)))][0][(0)],(2)),attachAspis($item,(2)));
$menu_file = attachAspis($submenu[0][deAspis(attachAspis($item,(2)))][0][(0)],(2));
if ( (false !== deAspis($pos = attAspis(strpos($menu_file[0],'?')))))
 $menu_file = Aspis_substr($menu_file,array(0,false),$pos);
if ( (((('index.php') != deAspis(attachAspis($submenu[0][deAspis(attachAspis($item,(2)))][0][(0)],(2)))) && file_exists((deconcat1(WP_PLUGIN_DIR,concat1("/",$menu_file))))) || (!((empty($menu_hook) || Aspis_empty( $menu_hook))))))
 {$admin_is_parent = array(true,false);
echo AspisCheckPrint(concat2(concat(concat2(concat(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<div class='wp-menu-image'><a href='admin.php?page=",attachAspis($submenu[0][deAspis(attachAspis($item,(2)))][0][(0)],(2))),"'>"),$img),"</a></div>"),$toggle),"<a href='admin.php?page="),attachAspis($submenu[0][deAspis(attachAspis($item,(2)))][0][(0)],(2))),"'"),$class),$tabindex),">"),attachAspis($item,(0))),"</a>"));
}else 
{{echo AspisCheckPrint(concat2(concat(concat2(concat(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("\n\t<div class='wp-menu-image'><a href='",attachAspis($submenu[0][deAspis(attachAspis($item,(2)))][0][(0)],(2))),"'>"),$img),"</a></div>"),$toggle),"<a href='"),attachAspis($submenu[0][deAspis(attachAspis($item,(2)))][0][(0)],(2))),"'"),$class),$tabindex),">"),attachAspis($item,(0))),"</a>"));
}}}else 
{if ( deAspis(current_user_can(attachAspis($item,(1)))))
 {$menu_hook = get_plugin_page_hook(attachAspis($item,(2)),array('admin.php',false));
$menu_file = attachAspis($item,(2));
if ( (false !== deAspis($pos = attAspis(strpos($menu_file[0],'?')))))
 $menu_file = Aspis_substr($menu_file,array(0,false),$pos);
if ( (((('index.php') != deAspis(attachAspis($item,(2)))) && file_exists((deconcat1(WP_PLUGIN_DIR,concat1("/",$menu_file))))) || (!((empty($menu_hook) || Aspis_empty( $menu_hook))))))
 {$admin_is_parent = array(true,false);
echo AspisCheckPrint(concat2(concat(concat2(concat(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("\n\t<div class='wp-menu-image'><a href='admin.php?page=",attachAspis($item,(2))),"'>"),$img),"</a></div>"),$toggle),"<a href='admin.php?page="),attachAspis($item,(2))),"'"),$class),$tabindex),">"),attachAspis($item,(0))),"</a>"));
}else 
{{echo AspisCheckPrint(concat2(concat(concat2(concat(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("\n\t<div class='wp-menu-image'><a href='",attachAspis($item,(2))),"'>"),$img),"</a></div>"),$toggle),"<a href='"),attachAspis($item,(2))),"'"),$class),$tabindex),">"),attachAspis($item,(0))),"</a>"));
}}}}if ( (!((empty($submenu[0][deAspis(attachAspis($item,(2)))]) || Aspis_empty( $submenu [0][deAspis(attachAspis( $item ,(2)))])))))
 {echo AspisCheckPrint(concat2(concat1("\n\t<div class='wp-submenu'><div class='wp-submenu-head'>",attachAspis($item,(0))),"</div><ul>"));
$first = array(true,false);
foreach ( deAspis(attachAspis($submenu,deAspis(attachAspis($item,(2))))) as $sub_key =>$sub_item )
{restoreTaint($sub_key,$sub_item);
{if ( (denot_boolean(current_user_can(attachAspis($sub_item,(1))))))
 continue ;
$class = array(array(),false);
if ( $first[0])
 {arrayAssignAdd($class[0][],addTaint(array('wp-first-item',false)));
$first = array(false,false);
}$menu_file = attachAspis($item,(2));
if ( (false !== deAspis($pos = attAspis(strpos($menu_file[0],'?')))))
 $menu_file = Aspis_substr($menu_file,array(0,false),$pos);
if ( ((isset($submenu_file) && Aspis_isset( $submenu_file))))
 {if ( ($submenu_file[0] == deAspis(attachAspis($sub_item,(2)))))
 arrayAssignAdd($class[0][],addTaint(array('current',false)));
}else 
{if ( (((((isset($plugin_page) && Aspis_isset( $plugin_page))) && ($plugin_page[0] == deAspis(attachAspis($sub_item,(2))))) && ((!(file_exists($menu_file[0]))) || (deAspis(attachAspis($item,(2))) == $self[0]))) || ((!((isset($plugin_page) && Aspis_isset( $plugin_page)))) && ($self[0] == deAspis(attachAspis($sub_item,(2)))))))
 {arrayAssignAdd($class[0][],addTaint(array('current',false)));
}}$class = $class[0] ? concat2(concat1(' class="',Aspis_join(array(' ',false),$class)),'"') : array('',false);
$menu_hook = get_plugin_page_hook(attachAspis($sub_item,(2)),attachAspis($item,(2)));
$sub_file = attachAspis($sub_item,(2));
if ( (false !== deAspis($pos = attAspis(strpos($sub_file[0],'?')))))
 $sub_file = Aspis_substr($sub_file,array(0,false),$pos);
if ( (((('index.php') != deAspis(attachAspis($sub_item,(2)))) && file_exists((deconcat1(WP_PLUGIN_DIR,concat1("/",$sub_file))))) || (!((empty($menu_hook) || Aspis_empty( $menu_hook))))))
 {$parent_exists = array((((denot_boolean($admin_is_parent)) && file_exists((deconcat1(WP_PLUGIN_DIR,concat1("/",$menu_file))))) && (!(is_dir((deconcat1(WP_PLUGIN_DIR,concat1("/",attachAspis($item,(2))))))))) || file_exists($menu_file[0]),false);
if ( $parent_exists[0])
 echo AspisCheckPrint(concat2(concat(concat2(concat(concat(concat2(concat(concat2(concat(concat2(concat1("<li",$class),"><a href='"),attachAspis($item,(2))),"?page="),attachAspis($sub_item,(2))),"'"),$class),$tabindex),">"),attachAspis($sub_item,(0))),"</a></li>"));
elseif ( ((('admin.php') == $pagenow[0]) || (denot_boolean($parent_exists))))
 echo AspisCheckPrint(concat2(concat(concat2(concat(concat(concat2(concat(concat2(concat1("<li",$class),"><a href='admin.php?page="),attachAspis($sub_item,(2))),"'"),$class),$tabindex),">"),attachAspis($sub_item,(0))),"</a></li>"));
else 
{echo AspisCheckPrint(concat2(concat(concat2(concat(concat(concat2(concat(concat2(concat(concat2(concat1("<li",$class),"><a href='"),attachAspis($item,(2))),"?page="),attachAspis($sub_item,(2))),"'"),$class),$tabindex),">"),attachAspis($sub_item,(0))),"</a></li>"));
}}else 
{{echo AspisCheckPrint(concat2(concat(concat2(concat(concat(concat2(concat(concat2(concat1("<li",$class),"><a href='"),attachAspis($sub_item,(2))),"'"),$class),$tabindex),">"),attachAspis($sub_item,(0))),"</a></li>"));
}}}}echo AspisCheckPrint(array("</ul></div>",false));
}echo AspisCheckPrint(array("</li>",false));
}} }
;
?>

<ul id="adminmenu">

<?php _wp_menu_output($menu,$submenu);
do_action(array('adminmenu',false));
;
?>
</ul>
<?php 