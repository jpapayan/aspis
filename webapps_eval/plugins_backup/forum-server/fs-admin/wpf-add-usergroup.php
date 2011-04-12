<?php
/************************ wpf-add-usergroup.php ************************************/
$image = WPFURL."images/user.png";
echo "<div class='wrap'> <h2>";
echo "<h2><img src='$image'> Add User Group</h2>";
echo '<form id="usergroupadd" name="usergroupadd" method="post" action="">';
if (function_exists('wp_nonce_field'))
				wp_nonce_field('vasthtml-add_usergroup');
  echo "<table class='widefat'>
    <thead>
      <tr>
        <th>Name</th>
        <th>Description</th>
      </tr>
    </thead>
    <tr class='alternate'>
      <td><input type='text' value='' name='group_name' /></td>
      <td><input type='text' value='' name='group_description' /></td>
     </tr>
      <tr class='alternate'>
      <td colspan='2'><input class='button' type='submit' name='add_usergroup' value='".__("Save user group", "vasthtml")."'/></td>
     </tr>
  </table></form>
</div>";
/*********************************************************************/
?>