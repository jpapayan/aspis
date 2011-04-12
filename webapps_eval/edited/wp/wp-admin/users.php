<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
require_once (deconcat2(concat12(ABSPATH,WPINC),'/registration.php'));
if ( (denot_boolean(current_user_can(array('edit_users',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
$title = __(array('Users',false));
$parent_file = array('users.php',false);
$update = $doaction = array('',false);
if ( ((isset($_REQUEST[0][('action')]) && Aspis_isset( $_REQUEST [0][('action')]))))
 $doaction = deAspis($_REQUEST[0]['action']) ? $_REQUEST[0]['action'] : $_REQUEST[0]['action2'];
if ( ((empty($doaction) || Aspis_empty( $doaction))))
 {if ( (((isset($_GET[0][('changeit')]) && Aspis_isset( $_GET [0][('changeit')]))) && (!((empty($_GET[0][('new_role')]) || Aspis_empty( $_GET [0][('new_role')]))))))
 $doaction = array('promote',false);
}if ( ((empty($_REQUEST) || Aspis_empty( $_REQUEST))))
 {$referer = concat2(concat1('<input type="hidden" name="wp_http_referer" value="',esc_attr(Aspis_stripslashes($_SERVER[0]['REQUEST_URI']))),'" />');
}elseif ( ((isset($_REQUEST[0][('wp_http_referer')]) && Aspis_isset( $_REQUEST [0][('wp_http_referer')]))))
 {$redirect = remove_query_arg(array(array(array('wp_http_referer',false),array('updated',false),array('delete_count',false)),false),Aspis_stripslashes($_REQUEST[0]['wp_http_referer']));
$referer = concat2(concat1('<input type="hidden" name="wp_http_referer" value="',esc_attr($redirect)),'" />');
}else 
{{$redirect = array('users.php',false);
$referer = array('',false);
}}switch ( $doaction[0] ) {
case ('promote'):check_admin_referer(array('bulk-users',false));
if ( ((empty($_REQUEST[0][('users')]) || Aspis_empty( $_REQUEST [0][('users')]))))
 {wp_redirect($redirect);
Aspis_exit();
}$editable_roles = get_editable_roles();
if ( (denot_boolean(attachAspis($editable_roles,deAspis($_REQUEST[0]['new_role'])))))
 wp_die(__(array('You can&#8217;t give users that role.',false)));
$userids = $_REQUEST[0]['users'];
$update = array('promote',false);
foreach ( $userids[0] as $id  )
{if ( (denot_boolean(current_user_can(array('edit_user',false),$id))))
 wp_die(__(array('You can&#8217;t edit that user.',false)));
if ( (($id[0] == $current_user[0]->ID[0]) && (denot_boolean($wp_roles[0]->role_objects[0][deAspis($_REQUEST[0]['new_role'])][0]->has_cap(array('edit_users',false))))))
 {$update = array('err_admin_role',false);
continue ;
}$user = array(new WP_User($id),false);
$user[0]->set_role($_REQUEST[0]['new_role']);
}wp_redirect(add_query_arg(array('update',false),$update,$redirect));
Aspis_exit();
break ;
case ('dodelete'):check_admin_referer(array('delete-users',false));
if ( ((empty($_REQUEST[0][('users')]) || Aspis_empty( $_REQUEST [0][('users')]))))
 {wp_redirect($redirect);
Aspis_exit();
}if ( (denot_boolean(current_user_can(array('delete_users',false)))))
 wp_die(__(array('You can&#8217;t delete users.',false)));
$userids = $_REQUEST[0]['users'];
$update = array('del',false);
$delete_count = array(0,false);
foreach ( deAspis(array_cast($userids)) as $id  )
{if ( (denot_boolean(current_user_can(array('delete_user',false),$id))))
 wp_die(__(array('You can&#8217;t delete that user.',false)));
if ( ($id[0] == $current_user[0]->ID[0]))
 {$update = array('err_admin_del',false);
continue ;
}switch ( deAspis($_REQUEST[0]['delete_option']) ) {
case ('delete'):wp_delete_user($id);
break ;
case ('reassign'):wp_delete_user($id,$_REQUEST[0]['reassign_user']);
break ;
 }
preincr($delete_count);
}$redirect = add_query_arg(array(array(deregisterTaint(array('delete_count',false)) => addTaint($delete_count),deregisterTaint(array('update',false)) => addTaint($update)),false),$redirect);
wp_redirect($redirect);
Aspis_exit();
break ;
case ('delete'):check_admin_referer(array('bulk-users',false));
if ( (((empty($_REQUEST[0][('users')]) || Aspis_empty( $_REQUEST [0][('users')]))) && ((empty($_REQUEST[0][('user')]) || Aspis_empty( $_REQUEST [0][('user')])))))
 {wp_redirect($redirect);
Aspis_exit();
}if ( (denot_boolean(current_user_can(array('delete_users',false)))))
 $errors = array(new WP_Error(array('edit_users',false),__(array('You can&#8217;t delete users.',false))),false);
if ( ((empty($_REQUEST[0][('users')]) || Aspis_empty( $_REQUEST [0][('users')]))))
 $userids = array(array(Aspis_intval($_REQUEST[0]['user'])),false);
else 
{$userids = $_REQUEST[0]['users'];
}include ('admin-header.php');
;
?>
<form action="" method="post" name="updateusers" id="updateusers">
<?php wp_nonce_field(array('delete-users',false));
?>
<?php echo AspisCheckPrint($referer);
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php _e(array('Delete Users',false));
;
?></h2>
<p><?php _e(array('You have specified these users for deletion:',false));
;
?></p>
<ul>
<?php $go_delete = array(false,false);
foreach ( deAspis(array_cast($userids)) as $id  )
{$id = int_cast($id);
$user = array(new WP_User($id),false);
if ( ($id[0] == $current_user[0]->ID[0]))
 {echo AspisCheckPrint(concat2(concat1("<li>",Aspis_sprintf(__(array('ID #%1s: %2s <strong>The current user will not be deleted.</strong>',false)),$id,$user[0]->user_login)),"</li>\n"));
}else 
{{echo AspisCheckPrint(concat2(concat(concat2(concat1("<li><input type=\"hidden\" name=\"users[]\" value=\"",esc_attr($id)),"\" />"),Aspis_sprintf(__(array('ID #%1s: %2s',false)),$id,$user[0]->user_login)),"</li>\n"));
$go_delete = array(true,false);
}}}$all_logins = $wpdb[0]->get_results(concat2(concat1("SELECT ID, user_login FROM ",$wpdb[0]->users)," ORDER BY user_login"));
$user_dropdown = array('<select name="reassign_user">',false);
foreach ( deAspis(array_cast($all_logins)) as $login  )
if ( (($login[0]->ID[0] == $current_user[0]->ID[0]) || (denot_boolean(Aspis_in_array($login[0]->ID,$userids)))))
 $user_dropdown = concat($user_dropdown,concat(concat1("<option value=\"",esc_attr($login[0]->ID)),concat2(concat1("\">",$login[0]->user_login),"</option>")));
$user_dropdown = concat2($user_dropdown,'</select>');
;
?>
	</ul>
<?php if ( $go_delete[0])
 {;
?>
	<fieldset><p><legend><?php _e(array('What should be done with posts and links owned by this user?',false));
;
?></legend></p>
	<ul style="list-style:none;">
		<li><label><input type="radio" id="delete_option0" name="delete_option" value="delete" checked="checked" />
		<?php _e(array('Delete all posts and links.',false));
;
?></label></li>
		<li><input type="radio" id="delete_option1" name="delete_option" value="reassign" />
		<?php echo AspisCheckPrint(concat(concat1('<label for="delete_option1">',__(array('Attribute all posts and links to:',false))),concat1("</label> ",$user_dropdown)));
;
?></li>
	</ul></fieldset>
	<input type="hidden" name="action" value="dodelete" />
	<p class="submit"><input type="submit" name="submit" value="<?php esc_attr_e(array('Confirm Deletion',false));
;
?>" class="button-secondary" /></p>
<?php }else 
{;
?>
	<p><?php _e(array('There are no valid users selected for deletion.',false));
;
?></p>
<?php };
?>
</div>
</form>
<?php break ;
default :if ( (!((empty($_GET[0][('_wp_http_referer')]) || Aspis_empty( $_GET [0][('_wp_http_referer')])))))
 {wp_redirect(remove_query_arg(array(array(array('_wp_http_referer',false),array('_wpnonce',false)),false),Aspis_stripslashes($_SERVER[0]['REQUEST_URI'])));
Aspis_exit();
}include ('admin-header.php');
$usersearch = ((isset($_GET[0][('usersearch')]) && Aspis_isset( $_GET [0][('usersearch')]))) ? $_GET[0]['usersearch'] : array(null,false);
$userspage = ((isset($_GET[0][('userspage')]) && Aspis_isset( $_GET [0][('userspage')]))) ? $_GET[0]['userspage'] : array(null,false);
$role = ((isset($_GET[0][('role')]) && Aspis_isset( $_GET [0][('role')]))) ? $_GET[0]['role'] : array(null,false);
$wp_user_search = array(new WP_User_Search($usersearch,$userspage,$role),false);
$messages = array(array(),false);
if ( ((isset($_GET[0][('update')]) && Aspis_isset( $_GET [0][('update')]))))
 {switch ( deAspis($_GET[0]['update']) ) {
case ('del'):case ('del_many'):$delete_count = ((isset($_GET[0][('delete_count')]) && Aspis_isset( $_GET [0][('delete_count')]))) ? int_cast($_GET[0]['delete_count']) : array(0,false);
arrayAssignAdd($messages[0][],addTaint(concat2(concat1('<div id="message" class="updated fade"><p>',Aspis_sprintf(_n(array('%s user deleted',false),array('%s users deleted',false),$delete_count),$delete_count)),'</p></div>')));
break ;
case ('add'):arrayAssignAdd($messages[0][],addTaint(concat2(concat1('<div id="message" class="updated fade"><p>',__(array('New user created.',false))),'</p></div>')));
break ;
case ('promote'):arrayAssignAdd($messages[0][],addTaint(concat2(concat1('<div id="message" class="updated fade"><p>',__(array('Changed roles.',false))),'</p></div>')));
break ;
case ('err_admin_role'):arrayAssignAdd($messages[0][],addTaint(concat2(concat1('<div id="message" class="error"><p>',__(array('The current user&#8217;s role must have user editing capabilities.',false))),'</p></div>')));
arrayAssignAdd($messages[0][],addTaint(concat2(concat1('<div id="message" class="updated fade"><p>',__(array('Other user roles have been changed.',false))),'</p></div>')));
break ;
case ('err_admin_del'):arrayAssignAdd($messages[0][],addTaint(concat2(concat1('<div id="message" class="error"><p>',__(array('You can&#8217;t delete the current user.',false))),'</p></div>')));
arrayAssignAdd($messages[0][],addTaint(concat2(concat1('<div id="message" class="updated fade"><p>',__(array('Other users have been deleted.',false))),'</p></div>')));
break ;
 }
};
?>

<?php if ( (((isset($errors) && Aspis_isset( $errors))) && deAspis(is_wp_error($errors))))
 {;
?>
	<div class="error">
		<ul>
		<?php foreach ( deAspis($errors[0]->get_error_messages()) as $err  )
echo AspisCheckPrint(concat2(concat1("<li>",$err),"</li>\n"));
;
?>
		</ul>
	</div>
<?php }if ( (!((empty($messages) || Aspis_empty( $messages)))))
 {foreach ( $messages[0] as $msg  )
echo AspisCheckPrint($msg);
};
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?>  <a href="user-new.php" class="button add-new-h2"><?php echo AspisCheckPrint(esc_html_x(array('Add New',false),array('user',false)));
;
?></a> <?php if ( (((isset($_GET[0][('usersearch')]) && Aspis_isset( $_GET [0][('usersearch')]))) && deAspis($_GET[0]['usersearch'])))
 printf((deconcat2(concat1('<span class="subtitle">',__(array('Search results for &#8220;%s&#8221;',false))),'</span>')),deAspisRC(esc_html($_GET[0]['usersearch'])));
;
?>
</h2>

<div class="filter">
<form id="list-filter" action="" method="get">
<ul class="subsubsub">
<?php $role_links = array(array(),false);
$avail_roles = array(array(),false);
$users_of_blog = get_users_of_blog();
$total_users = attAspis(count($users_of_blog[0]));
foreach ( deAspis(array_cast($users_of_blog)) as $b_user  )
{$b_roles = Aspis_unserialize($b_user[0]->meta_value);
foreach ( deAspis(array_cast($b_roles)) as $b_role =>$val )
{restoreTaint($b_role,$val);
{if ( (!((isset($avail_roles[0][$b_role[0]]) && Aspis_isset( $avail_roles [0][$b_role[0]])))))
 arrayAssign($avail_roles[0],deAspis(registerTaint($b_role)),addTaint(array(0,false)));
postincr(attachAspis($avail_roles,$b_role[0]));
}}}unset($users_of_blog);
$current_role = array(false,false);
$class = ((empty($role) || Aspis_empty( $role))) ? array(' class="current"',false) : array('',false);
arrayAssignAdd($role_links[0][],addTaint(concat2(concat(concat2(concat1("<li><a href='users.php'",$class),">"),Aspis_sprintf(_nx(array('All <span class="count">(%s)</span>',false),array('All <span class="count">(%s)</span>',false),$total_users,array('users',false)),number_format_i18n($total_users))),'</a>')));
foreach ( deAspis($wp_roles[0]->get_names()) as $this_role =>$name )
{restoreTaint($this_role,$name);
{if ( (!((isset($avail_roles[0][$this_role[0]]) && Aspis_isset( $avail_roles [0][$this_role[0]])))))
 continue ;
$class = array('',false);
if ( ($this_role[0] == $role[0]))
 {$current_role = $role;
$class = array(' class="current"',false);
}$name = translate_user_role($name);
$name = Aspis_sprintf(__(array('%1$s <span class="count">(%2$s)</span>',false)),$name,attachAspis($avail_roles,$this_role[0]));
arrayAssignAdd($role_links[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1("<li><a href='users.php?role=",$this_role),"'"),$class),">"),$name),"</a>")));
}}echo AspisCheckPrint(concat2(Aspis_implode(array(" |</li>\n",false),$role_links),'</li>'));
unset($role_links);
;
?>
</ul>
</form>
</div>

<form class="search-form" action="" method="get">
<p class="search-box">
	<label class="screen-reader-text" for="user-search-input"><?php _e(array('Search Users',false));
;
?>:</label>
	<input type="text" id="user-search-input" name="usersearch" value="<?php echo AspisCheckPrint(esc_attr($wp_user_search[0]->search_term));
;
?>" />
	<input type="submit" value="<?php esc_attr_e(array('Search Users',false));
;
?>" class="button" />
</p>
</form>

<form id="posts-filter" action="" method="get">
<div class="tablenav">

<?php if ( deAspis($wp_user_search[0]->results_are_paged()))
 {;
?>
	<div class="tablenav-pages"><?php $wp_user_search[0]->page_links();
;
?></div>
<?php };
?>

<div class="alignleft actions">
<select name="action">
<option value="" selected="selected"><?php _e(array('Bulk Actions',false));
;
?></option>
<option value="delete"><?php _e(array('Delete',false));
;
?></option>
</select>
<input type="submit" value="<?php esc_attr_e(array('Apply',false));
;
?>" name="doaction" id="doaction" class="button-secondary action" />
<label class="screen-reader-text" for="new_role"><?php _e(array('Change role to&hellip;',false));
?></label><select name="new_role" id="new_role"><option value=''><?php _e(array('Change role to&hellip;',false));
?></option><?php wp_dropdown_roles();
;
?></select>
<input type="submit" value="<?php esc_attr_e(array('Change',false));
;
?>" name="changeit" class="button-secondary" />
<?php wp_nonce_field(array('bulk-users',false));
;
?>
</div>

<br class="clear" />
</div>

	<?php if ( deAspis(is_wp_error($wp_user_search[0]->search_errors)))
 {;
?>
		<div class="error">
			<ul>
			<?php foreach ( deAspis($wp_user_search[0]->search_errors[0]->get_error_messages()) as $message  )
echo AspisCheckPrint(concat2(concat1("<li>",$message),"</li>"));
;
?>
			</ul>
		</div>
	<?php };
?>


<?php if ( deAspis($wp_user_search[0]->get_results()))
 {;
?>

	<?php if ( deAspis($wp_user_search[0]->is_search()))
 {;
?>
		<p><a href="users.php"><?php _e(array('&larr; Back to All Users',false));
;
?></a></p>
	<?php };
?>

<table class="widefat fixed" cellspacing="0">
<thead>
<tr class="thead">
<?php print_column_headers(array('users',false));
?>
</tr>
</thead>

<tfoot>
<tr class="thead">
<?php print_column_headers(array('users',false),array(false,false));
?>
</tr>
</tfoot>

<tbody id="users" class="list:user user-list">
<?php $style = array('',false);
foreach ( deAspis($wp_user_search[0]->get_results()) as $userid  )
{$user_object = array(new WP_User($userid),false);
$roles = $user_object[0]->roles;
$role = Aspis_array_shift($roles);
$style = ((' class="alternate"') == $style[0]) ? array('',false) : array(' class="alternate"',false);
echo AspisCheckPrint(concat1("\n\t",user_row($user_object,$style,$role)));
};
?>
</tbody>
</table>

<div class="tablenav">

<?php if ( deAspis($wp_user_search[0]->results_are_paged()))
 {;
?>
	<div class="tablenav-pages"><?php $wp_user_search[0]->page_links();
;
?></div>
<?php };
?>

<div class="alignleft actions">
<select name="action2">
<option value="" selected="selected"><?php _e(array('Bulk Actions',false));
;
?></option>
<option value="delete"><?php _e(array('Delete',false));
;
?></option>
</select>
<input type="submit" value="<?php esc_attr_e(array('Apply',false));
;
?>" name="doaction2" id="doaction2" class="button-secondary action" />
</div>

<br class="clear" />
</div>

<?php };
?>

</form>
</div>

<br class="clear" />
<?php break ;
 }
include ('admin-footer.php');
;
?>
<?php 