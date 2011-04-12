<?php 
/*************** wpf-add-forum.php *********************/
   $image = WPFURL."images/table.png";
	echo "<div class='wrap'>
  <h2><img src='$image'> Add category</h2>
  <form name='add_group_form' method='post' id='add_group_form' action='".ADMIN_BASE_URL."structure'>
  <table class='widefat'>
    <thead>
      <tr>
        <th>Name</th>
        <th>Description</th>
      </tr>
    </thead>
    <tr class='alternate'>
      <td> <input type='text' value='' name='add_group_name' /> </td>
      <td><textarea name='add_group_description' ".ADMIN_ROW_COL."></textarea> </td>
    </tr>
    <tr class='alternate'>
      <td colspan='2'><input class='button' type='submit' value='Save category' name='add_group_submit' /></td>
    </tr>
  </table></form>
</div>";

/**********************************************************/

?>