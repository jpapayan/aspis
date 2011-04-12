<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
wp_reset_vars(array(array(array('revision',false),array('left',false),array('right',false),array('diff',false),array('action',false)),false));
$revision_id = absint($revision);
$diff = absint($diff);
$left = absint($left);
$right = absint($right);
$parent_file = $redirect = array('edit.php',false);
switch ( $action[0] ) {
case ('delete'):;
case ('edit'):if ( deAspis(attAspisRC(constant(('WP_POST_REVISIONS')))))
 $redirect = remove_query_arg(array('action',false));
else 
{$redirect = array('edit.php',false);
}break ;
case ('restore'):if ( (denot_boolean($revision = wp_get_post_revision($revision_id))))
 break ;
if ( (denot_boolean(current_user_can(array('edit_post',false),$revision[0]->post_parent))))
 break ;
if ( (denot_boolean($post = get_post($revision[0]->post_parent))))
 break ;
if ( ((denot_boolean(attAspisRC(constant(('WP_POST_REVISIONS'))))) && (denot_boolean(wp_is_post_autosave($revision)))))
 break ;
check_admin_referer(concat(concat2(concat1("restore-post_",$post[0]->ID),"|"),$revision[0]->ID));
wp_restore_post_revision($revision[0]->ID);
$redirect = add_query_arg(array(array('message' => array(5,false,false),deregisterTaint(array('revision',false)) => addTaint($revision[0]->ID)),false),get_edit_post_link($post[0]->ID,array('url',false)));
break ;
case ('diff'):if ( (denot_boolean($left_revision = get_post($left))))
 break ;
if ( (denot_boolean($right_revision = get_post($right))))
 break ;
if ( ((denot_boolean(current_user_can(array('read_post',false),$left_revision[0]->ID))) || (denot_boolean(current_user_can(array('read_post',false),$right_revision[0]->ID)))))
 break ;
if ( ($left_revision[0]->ID[0] == $right_revision[0]->ID[0]))
 {$redirect = get_edit_post_link($left_revision[0]->ID);
include ('js/revisions-js.php');
break ;
}if ( (strtotime($right_revision[0]->post_modified_gmt[0]) < strtotime($left_revision[0]->post_modified_gmt[0])))
 {$redirect = add_query_arg(array(array(deregisterTaint(array('left',false)) => addTaint($right),deregisterTaint(array('right',false)) => addTaint($left)),false));
break ;
}if ( ($left_revision[0]->ID[0] == $right_revision[0]->post_parent[0]))
 $post = &$left_revision;
elseif ( ($left_revision[0]->post_parent[0] == $right_revision[0]->ID[0]))
 $post = &$right_revision;
elseif ( ($left_revision[0]->post_parent[0] == $right_revision[0]->post_parent[0]))
 $post = get_post($left_revision[0]->post_parent);
else 
{break ;
}if ( (denot_boolean(attAspisRC(constant(('WP_POST_REVISIONS'))))))
 {if ( (((denot_boolean(wp_is_post_autosave($left_revision))) && (denot_boolean(wp_is_post_autosave($right_revision)))) || (($post[0]->ID[0] !== $left_revision[0]->ID[0]) && ($post[0]->ID[0] !== $right_revision[0]->ID[0]))))
 break ;
}if ( (($left_revision[0]->ID[0] == $right_revision[0]->ID[0]) || ((denot_boolean(wp_get_post_revision($left_revision[0]->ID))) && (denot_boolean(wp_get_post_revision($right_revision[0]->ID))))))
 break ;
$post_title = concat2(concat(concat2(concat1('<a href="',get_edit_post_link()),'">'),get_the_title()),'</a>');
$h2 = Aspis_sprintf(__(array('Compare Revisions of &#8220;%1$s&#8221;',false)),$post_title);
$left = $left_revision[0]->ID;
$right = $right_revision[0]->ID;
$redirect = array(false,false);
break ;
case ('view'):default :if ( (denot_boolean($revision = wp_get_post_revision($revision_id))))
 break ;
if ( (denot_boolean($post = get_post($revision[0]->post_parent))))
 break ;
if ( ((denot_boolean(current_user_can(array('read_post',false),$revision[0]->ID))) || (denot_boolean(current_user_can(array('read_post',false),$post[0]->ID)))))
 break ;
if ( ((denot_boolean(attAspisRC(constant(('WP_POST_REVISIONS'))))) && (denot_boolean(wp_is_post_autosave($revision)))))
 break ;
$post_title = concat2(concat(concat2(concat1('<a href="',get_edit_post_link()),'">'),get_the_title()),'</a>');
$revision_title = wp_post_revision_title($revision,array(false,false));
$h2 = Aspis_sprintf(__(array('Post Revision for &#8220;%1$s&#8221; created on %2$s',false)),$post_title,$revision_title);
$left = $revision[0]->ID;
$right = $post[0]->ID;
$redirect = array(false,false);
break ;
 }
if ( ((denot_boolean($redirect)) && (denot_boolean(Aspis_in_array($post[0]->post_type,array(array(array('post',false),array('page',false)),false))))))
 $redirect = array('edit.php',false);
if ( $redirect[0])
 {wp_redirect($redirect);
Aspis_exit();
}if ( (('page') == $post[0]->post_type[0]))
 {$submenu_file = array('edit-pages.php',false);
$title = __(array('Page Revisions',false));
}else 
{{$submenu_file = array('edit.php',false);
$title = __(array('Post Revisions',false));
}}require_once ('admin-header.php');
;
?>

<div class="wrap">

<h2 class="long-header"><?php echo AspisCheckPrint($h2);
;
?></h2>

<table class="form-table ie-fixed">
	<col class="th" />
<?php if ( (('diff') == $action[0]))
 {;
?>
<tr id="revision">
	<th scope="row"></th>
	<th scope="col" class="th-full">
		<span class="alignleft"><?php printf(deAspis(__(array('Older: %s',false))),deAspisRC(wp_post_revision_title($left_revision)));
;
?></span>
		<span class="alignright"><?php printf(deAspis(__(array('Newer: %s',false))),deAspisRC(wp_post_revision_title($right_revision)));
;
?></span>
	</th>
</tr>
<?php }$identical = array(true,false);
foreach ( deAspis(_wp_post_revision_fields()) as $field =>$field_title )
{restoreTaint($field,$field_title);
{if ( (('diff') == $action[0]))
 {$left_content = apply_filters(concat1("_wp_post_revision_field_",$field),$left_revision[0]->$field[0],$field);
$right_content = apply_filters(concat1("_wp_post_revision_field_",$field),$right_revision[0]->$field[0],$field);
if ( (denot_boolean($content = wp_text_diff($left_content,$right_content))))
 continue ;
$identical = array(false,false);
}else 
{{add_filter(concat1("_wp_post_revision_field_",$field),array('htmlspecialchars',false));
$content = apply_filters(concat1("_wp_post_revision_field_",$field),$revision[0]->$field[0],$field);
}};
?>

	<tr id="revision-field-<?php echo AspisCheckPrint($field);
;
?>">
		<th scope="row"><?php echo AspisCheckPrint(esc_html($field_title));
;
?></th>
		<td><div class="pre"><?php echo AspisCheckPrint($content);
;
?></div></td>
	</tr>

	<?php }}if ( ((('diff') == $action[0]) && $identical[0]))
 {;
?>

	<tr><td colspan="2"><div class="updated"><p><?php _e(array('These revisions are identical.',false));
;
?></p></div></td></tr>

	<?php };
?>

</table>

<br class="clear" />

<h2><?php echo AspisCheckPrint($title);
;
?></h2>

<?php $args = array(array('format' => array('form-table',false,false),'parent' => array(true,false,false),deregisterTaint(array('right',false)) => addTaint($right),deregisterTaint(array('left',false)) => addTaint($left)),false);
if ( (denot_boolean(attAspisRC(constant(('WP_POST_REVISIONS'))))))
 arrayAssign($args[0],deAspis(registerTaint(array('type',false))),addTaint(array('autosave',false)));
wp_list_post_revisions($post,$args);
;
?>

</div>

<?php require_once ('admin-footer.php');
