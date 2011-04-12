<?php
{
global $wpdb, $table_prefix, $vasthtml;

		$mods = $vasthtml->get_moderators();
		$forums = $vasthtml->get_forums();
		$users = $vasthtml->get_users();
		$groups = $vasthtml->get_groups();
$image = WPFURL."images/user.png"; 
echo "<h2>".__("<img src='$image'> Add moderator", "vasthtml")."</h2>

<form name='add_mod_form' method='post' action='".ADMIN_BASE_URL."moderators'>
<table class='widefat'>
 <thead>
        <tr>
          <th>User</th>
          <th>Moderate</th>
        </tr>
      </thead>
	<tr>
		<td>
			<select name='addmod_user_id'><option selected='selected' value='add_mod_null'>".__("Select user", "vasthtml")."</option";
				foreach($users as $user)
					//if(!$vasthtml->is_moderator($user->ID))
						echo "<option value='$user->ID'>$user->user_login ($user->ID)</option>";
			echo "</select>";
		echo "</td>
		<td>";
		
		echo "<p class='wpf-alignright'><input type='checkbox'  id='mod_global' name='mod_global' onclick='invertAll(this, this.form, \"mod_forum_id\");' value='true' /> <strong>".__("Global moderator: (User can moderate all forums)", "vasthtml")."</strong></p>";
						foreach($groups as $group){
							$forums = $vasthtml->get_forums($group->id);
								echo "<p class='wpf-bordertop'><strong>".stripslashes($group->name)."</strong></p>";
								foreach($forums as $forum){
									echo "<p class='wpf-indent'><input type='checkbox' name='mod_forum_id[]' onclick='uncheckglobal(this, this.form);' id='mod_forum_id' value='$forum->id' /> $forum->name</p>";

								}
									
						}
									
					echo "</td></tr>
							<tr>
							
								<td colspan='2'>
								<span style='float:left'><input class='button' type='submit' name='add_mod_submit' value='".__("Add moderator", "vasthtml")."' /></span><span class='button' style='float:right'><a href='http://vasthtml.com' target='_blank'>Vast HTML</a></span></td>

							</tr>
				</tr>
			</table>";




}
?>