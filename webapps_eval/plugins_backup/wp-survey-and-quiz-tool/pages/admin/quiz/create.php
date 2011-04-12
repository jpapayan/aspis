<div class="wrap">

	<?php if ( isset($successMessage) ) {?>
		<div class='updated'><?php echo $successMessage; ?></div>
				
	<?php } ?>
	<div id="icon-tools" class="icon32"></div>
	<h2>
		WP Survey And Quiz Tool - Create Quiz
	</h2>
	
	<?php if ( isset($errorArray) && !empty($errorArray) ) { ?>
		<ul class="error">
			<?php foreach($errorArray as $error ){ ?>
				<li><?php echo $error; ?></li>
			<?php } ?>
		</ul>
	<?php } ?>
	<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="quiz_form">
		
		<input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>"  />
	
		<table class="form-table" id="question_form">
			<tbody>
				<tr>
					<th scope="row">Name</th>
					<td><input id="quiz_name" maxlength="255" size="50" name="quiz_name" value="<?php if ( isset($quizDetails['name']) ) { echo stripcslashes($quizDetails['name']); } ?>" /></td>
				</tr>
				<tr>
					<th scope="row">Complete Notification</th>
					<td>
						<select id="notification_type" name="notification_type">
							<option value="instant"<?php if ( !isset($quizDetails['notification_type']) ||  $quizDetails['notification_type'] == 'instant' ){?> selected="selected"<?php }?>>Instant</option>
							<option value="instant-100"<?php if ( isset($quizDetails['notification_type']) &&   $quizDetails['notification_type'] == 'instant-100' ){?> selected="selected"<?php }?>>Instant if 100% correct</option>
							<option value="instant-75"<?php if ( isset($quizDetails['notification_type']) &&   $quizDetails['notification_type'] == 'instant-75' ){?> selected="selected"<?php }?>>Instant if 75% correct</option>
							<option value="instant-50"<?php if ( isset($quizDetails['notification_type']) &&   $quizDetails['notification_type'] == 'instant-50' ){?> selected="selected"<?php }?>>Instant if 50% correct</option>
							<option value="hourly"<?php if ( isset($quizDetails['notification_type']) &&  $quizDetails['notification_type'] == 'hourly' ){?> selected="selected"<?php }?>>Batched - Hourly</option>
							<option value="daily"<?php if ( isset($quizDetails['notification_type']) &&  $quizDetails['notification_type'] == 'daily' ){?> selected="selected"<?php }?>>Batched - Daily</option>
							<option value="none"<?php if ( isset($quizDetails['notification_type']) &&  $quizDetails['notification_type'] == 'none' ){?> selected="selected"<?php }?>>None</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Display Result On Completion</th>
					<td>
						<select id="display_result" name="display_result">
							<option value="no"<?php if ( !isset($quizDetails['display_result']) ||  $quizDetails['display_result'] == 'no' ){?> selected="selected"<?php }?>>No</option>
							<option value="yes"<?php if ( isset($quizDetails['display_result']) &&  $quizDetails['display_result'] == 'yes' ){?> selected="selected"<?php }?>>Yes</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Status</th>
					<td>
						<select id="status" name="status">
							<option value="enabled"<?php if ( !isset($quizDetails['display_result']) ||  $quizDetails['display_result'] == 'enabled' ){?> selected="selected"<?php }?>>Enabled</option>
							<option value="disabled"<?php if ( isset($quizDetails['display_result']) && $quizDetails['display_result'] == 'disabled' ){?> selected="selected"<?php }?>>Disabled</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Contact Details Form</th>
					<td>
						<select id="take_details" name="take_details">
							<option value="no"<?php if ( !isset($quizDetails['take_details']) ||  $quizDetails['take_details'] == 'no' ){?> selected="selected"<?php }?>>No</option>
							<option value="yes"<?php if ( isset($quizDetails['take_details']) && $quizDetails['take_details'] == 'yes' ){?> selected="selected"<?php }?>>Yes</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Use Wordpress User Details</th>
					<td>
						<select id="use_wp_user" name="use_wp_user">
							<option value="no"<?php if ( !isset($quizDetails['use_wp_user']) ||  $quizDetails['use_wp_user'] == 'no' ){?> selected="selected"<?php }?>>No</option>
							<option value="yes"<?php if ( isset($quizDetails['use_wp_user']) && $quizDetails['use_wp_user'] == 'yes' ){?> selected="selected"<?php }?>>Yes</option>
						</select>
					</td>
				</tr>
				
			</tbody>
		</table>
		
		<p class="submit">
			<input class="button-primary" type="submit" name="Save" value="Save Quiz" id="submitbutton" />
		</p>
		
	</form>
	
</div>	