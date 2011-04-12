<?php
if(isset($_POST['edit_save_group'])){
	global $wpdb, $table_prefix;
	$usergroups = $_POST['usergroups'];
	$edit_group_name = $wpdb->escape($_POST['edit_group_name']);
	$edit_group_description = $wpdb->escape($_POST['edit_group_description']);
	$edit_group_id = $_POST['edit_group_id'];

	if($_POST['edit_group_name'] == "")
		echo "<div id='message' class='updated fade'><p>".__("You must specify a group name", "vasthtml")."</p></div>";
		
	$sql = "SELECT id FROM ".$table_prefix."forum_groups WHERE name = '$edit_group_name' AND id <> $edit_group_id";
	$name = $wpdb->get_var($sql);
	if($name)
		echo "<div id='message' class='updated fade'><p>".__("You have choosen a name that already exists in the database, please specify another", "vasthtml")."</p></div>";

	else{
		global $wpdb, $table_prefix;
		$wpdb->query("UPDATE ".$table_prefix."forum_groups SET name = '$edit_group_name', description = '$edit_group_description' WHERE id = $edit_group_id" );
	
		$this->update_usergroups($usergroups, $edit_group_id);
		echo "<div id='message' class='updated fade'><p>".__("Group updated successfully", "vasthtml")."</p></div>";
	}
}
if(isset($_POST['edit_save_forum'])){

	global $wpdb, $table_prefix;
	$edit_forum_name = $wpdb->escape($_POST['edit_forum_name']);
	$edit_forum_description = $wpdb->escape($_POST['edit_forum_description']);
	$edit_forum_id = $_POST['edit_forum_id'];
	if($edit_forum_name == "")
		echo "<div id='message' class='updated fade'><p>".__("You must specify a forum name", "vasthtml")."</p></div>";
	
	$wpdb->query("UPDATE ".$table_prefix."forum_forums SET name = '$edit_forum_name', description = '$edit_forum_description' WHERE id = $edit_forum_id" );
	echo "<div id='message' class='updated fade'><p>".__("Forum updated successfully", "vasthtml")."</p></div>";

}

if(($_GET['do'] == "editgroup") && (!isset($_POST['edit_save_group']))){

	$usergroups = $vasthtml->get_usergroups();
	$usergroups_with_access = $this->get_usersgroups_with_access_to_group($_GET['groupid']);
	$group_name = stripslashes($vasthtml->get_groupname($_GET['groupid']));
	global $wpdb, $table_prefix;
	$table = $table_prefix."forum_groups";

	echo "<h2>".__("Edit category", "vasthtml")." \"$group_name\"</h2>";

	echo "<form name='edit_group_form' method='post' action=''>";
	
	echo "<table class='form-table'>
			<tr>
				<th>".__("Name:", "vasthtml")."</th>
				<td><input type='text' value='$group_name' name='edit_group_name' /></td>
			</tr>
			<tr>
				<th>".__("Description", "vasthtml")."</th>
				<td><textarea name='edit_group_description' ".ADMIN_ROW_COL.">".stripslashes($vasthtml->get_group_description($_GET['groupid']))."</textarea></td>
			</tr>
			<tr>
				<th>".__("User Groups:", "vasthtml")."</th>
				<td>";
					
						echo "<strong>".__("Members of the checked User Groups have access to the forums in this category:", "vasthtml")."</strong>";
						if($usergroups){
							$i = 0;
							echo "<table class='wpf-wide'>";
							echo "<tr>";
							
							foreach($usergroups as $usergroup){
								$col = 4;
								if($vasthtml->array_search($usergroup->id, $usergroups_with_access))
									$checked = "checked='checked'";
								else
									$checked = "";
								$e = "<p><input type='checkbox' $checked name='usergroups[]' value='$usergroup->id'/> ".stripslashes($usergroup->name)."</p>\n\r";

								if($i == 0){
									echo "<td>$e";
									++$i;
								}
								elseif($i < $col){
									echo "$e";
									++$i;
								}
								else{
									echo "$e</td>";
									$i = 0;
								}
							
							}
							echo "</tr></table>";
						}
						
						else
							echo __("There are no User Groups", "vasthtml");	
						
				
				echo "</td>
			</tr>
			<tr>
				<th></th>
				<td><input type='submit' name='edit_save_group' value='".__("Save group", "vasthtml")."' /></td>
			</tr>

			<input type='hidden' name='edit_group_id' value='".$_GET['groupid']."' />";
	
	echo "</table>";
	
	echo "</form>";
	
}


if(($_GET['do'] == "editforum") && (!isset($_POST['edit_save_forum']))){

	echo "<h2>".__("Edit forum", "vasthtml")." \"".stripslashes($vasthtml->get_forumname($_GET['forumid']))."\"</h2>";
	echo "<form id='edit_forum_form' name='edit_forum_form' action='' method='post'>";
	
	echo "<table class='form-table'>";
	echo "<tr>
			<th>".__("Name:", "vasthtml")."</th>
			<td><input type='text' name='edit_forum_name' value='".stripslashes($vasthtml->get_forumname($_GET['forumid']))."' /></td>
		</tr>
		<tr>
			<th>".__("Description:", "vasthtml")."</th>
			<td><textarea name='edit_forum_description' ".ADMIN_ROW_COL.">".stripslashes($vasthtml->get_forum_description($_GET['forumid']))."</textarea></td>
		</tr>
		<tr>
			<th></th>
			<td><input type='submit' name='edit_save_forum' value='".__("Save forum", "vasthtml")."' /></td>
		</tr>
		<input type='hidden' name='edit_forum_id' value='".$_GET['forumid']."' />";

	echo "</table></form>";
}




















?>