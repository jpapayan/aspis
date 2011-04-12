<div class="wrap">
	
	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Options</h2>	
	
	<?php if ( isset($successMessage) ){ ?>
		<div class="updated" id="question_added"><?php echo $successMessage; ?></div>
	<?php } ?>
	
	<?php if ( isset($errorArray) && !empty($errorArray) ) { ?>
		<ul class="error">
			<?php foreach($errorArray as $error ){ ?>
				<li><?php echo $error; ?></li>
			<?php } ?>
		</ul>
	<?php } ?>
	
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		
		<table class="form-table">
			<tr>
				<th scope="row">Items Per Page</th>
				<td><select name="items">
						<option value="5" <?php if ($numberOfItems == 5){?> selected="yes"<?php }?>>5</option>
						<option value="10" <?php if ($numberOfItems == 10){?> selected="yes"<?php }?>>10</option>
						<option value="25" <?php if ($numberOfItems == 25){?> selected="yes"<?php }?>>25</option>
						<option value="100" <?php if ($numberOfItems == 100){?> selected="yes"<?php }?>>100</option>
				</select></td>
			</tr>
			<tr>
				<th scope="row">Notification Email</th>
				<td><input type="text" name="email" value="<?php echo $email; ?>" /></td>
			</tr>
		</table>
	
		<p class="submit">
			<input class="button-primary" type="submit" name="Save" value="Save Quiz" id="submitbutton" />
		</p>
		
	</form>
	
</div>	