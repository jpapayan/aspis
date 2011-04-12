<?php 
/*************** wpf-add-forum.php *********************/
	echo "<h2>".__("Add forum to", "vasthtml")." \"".stripslashes($vasthtml->get_groupname($_GET['groupid']))."\"</h2>";

	echo "<form name='add_forum_form' id='add_forum_form' method='post' action='".ADMIN_BASE_URL."structure'>";
	echo "<table class='form-table'>
			<tr>
				<th>".__("Name:", "vasthtml")."</th>
				<td><input type='text' value='' name='add_forum_name' /></td>
			</tr>
			<tr>
				<th>".__("Description:", "vasthtml")."</th>
				<td><textarea name='add_forum_description' ".ADMIN_ROW_COL."></textarea></td>
			</tr>
			<tr>";/*
				<th>".__("Add forum to:", "vasthtml")."</th>
					<td>
						<select name='add_forum_group_id'>
							<option selected='selected' value='add_forum_null'>".__("Select group", "vasthtml")."</option>";
							foreach($groups as $group){
								echo "<option value='$group->id'>$group->name</option>";
							}
						echo "</select>
					</td>
			</tr>*/
			echo "<tr>
				<th></th>
				<td><input type='submit' value='".__("Save forum", "vasthtml")."' name='add_forum_submit' /></td>
			</tr>
			<input type='hidden' name='add_forum_group_id' value='{$_GET['groupid']}' />";
	
	echo "</form></table>";
/**********************************************************/

?>
