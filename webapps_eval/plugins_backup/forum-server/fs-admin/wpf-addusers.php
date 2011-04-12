<?php 
$usergroups = $vasthtml->get_usergroups();
$users = $vasthtml->get_users();
$image = WPFURL."images/user.png";

echo "<div class='wrap'>
  <h2><img src='$image'> Add users</h2>";
echo "<form name='add_usertogroup_form' action='".ADMIN_BASE_URL."usergroups' method='post'>
 <table class='widefat'>
      <thead>
        <tr>
          <th>User names </th>
          <th>User group</th>
        </tr>
      </thead>
      <tr class='alternate'>
        <td>";
// change textarea to multiselect with array of IDs
//		echo "<textarea name='togroupusers' ".ADMIN_ROW_COL."></textarea><br/>";
		echo "<select name='togroupusers[]' class='userselect' multiple><option selected='selected' value='admin'>".__("Select user", "vasthtml")."</option";
				foreach($users as $user)
					echo "<option value='$user->user_login'>$user->user_login (ID: $user->ID)</option>";
				
		echo "</select><br/>";
		echo "<i>".__("You can select multiple users", "vasthtml")."</i>";
		echo "</td>";
		echo "<td>";

			echo "<select name='usergroup'>
			<option selected='selected' value='add_user_null'>".__("Select User group", "vasthtml")."
            </option>";
            
            foreach($usergroups as $usergroup){
            echo "<option value='$usergroup->id'>
				$usergroup->name</option>";
                }
                echo "</select></td>
      </tr>
      <tr class='alternate'>
        <td colspan='2'><input class='button' name='add_user_togroup' type='submit' value='".__("Add users", "vasthtml")."' /></td>
      </tr>
    </table>
</form>
</div>";
