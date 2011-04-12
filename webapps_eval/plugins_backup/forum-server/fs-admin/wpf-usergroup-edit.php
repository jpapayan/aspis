<?php
if(isset($_POST['edit_usergroup_submit'])){
	global $wpdb, $table_prefix;
	$edit_usergroup_name = $wpdb->escape($_POST['edit_usergroup_name']);
	$edit_usergroup_description = $wpdb->escape($_POST['edit_usergroup_description']);
	$edit_usergroup_id = $_POST['edit_usergroup_id'];
	
	if(!$edit_usergroup_name)
		echo "<div id='message' class='updated fade'><p>".__("You must specify a name for the User Group", "vasthtml")."</p></div>";

	else if($wpdb->get_var("SELECT id FROM ".$table_prefix."forum_usergroups WHERE name = '$edit_usergroup_name' AND id <> $edit_usergroup_id"))
		echo "<div id='message' class='updated fade'><p>".__("You have choosen a name that already exists in the database, please specify another", "vasthtml")."</p></div>";

	else{
		$wpdb->query("UPDATE ".$table_prefix."forum_usergroups SET name = '$edit_usergroup_name', description = '$edit_usergroup_description' WHERE id = $edit_usergroup_id" );
		echo "<div id='message' class='updated fade'><p>".__("User Group updated successfully", "vasthtml")."</p></div>";
	}
}


else{
	$name = $vasthtml->get_usergroup_name($_GET['usergroup_id']);
	echo "<h2>".__("Edit User Group", "vasthtml"). " \"$name\"</h2>";
	echo "<form name='edit_usergroup_form' action='' method='post'>";
	
	echo "<table class='form-table'>
			<tr>
				<th>".__("Name:", "vasthtml")."</th>
				<td><input type='' value='$name' name='edit_usergroup_name' /></td>
			</tr>
			<tr>
				<th>".__("Description:", "vasthtml")."</th>
				<td><textarea name='edit_usergroup_description' ".ADMIN_ROW_COL.">".$vasthtml->get_usergroup_description($_GET['usergroup_id'])."</textarea></td>
			</tr>
			<tr>
				<th></th>
				<td><input type='submit' name='edit_usergroup_submit' value='".__("Save User Group", "vasthtml")."'</td>
			</tr>
			
			<input type='hidden' value='{$_GET['usergroup_id']}' name='edit_usergroup_id' />";
	echo "</table></form>";
}
?>