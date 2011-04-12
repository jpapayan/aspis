<div class="wrap">

	<?php if ( isset($successMessage) ) {?>
		<div class='updated'><?php echo $successMessage; ?></div>
				
	<?php } ?>
	<div id="icon-tools" class="icon32"></div>
	<h2>
		WP Survey And Quiz Tool - Create Survey
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
					<td><input id="survey_name" maxlength="255" size="50" name="survey_name" value="<?php if ( isset($surveyDetails['name']) ) { echo stripcslashes($surveyDetails['name']); } ?>" /></td>
				</tr>
				<tr>
					<th scope="row">Status</th>
					<td>
						<select id="status" name="status">
							<option value="enabled"<?php if ( !isset($surveyDetails['status']) ||  $surveyDetails['status'] == 'enabled' ){?> selected="selected"<?php }?>>Enabled</option>
							<option value="disabled"<?php if ( isset($surveyDetails['status']) && $surveyDetails['status'] == 'disabled' ){?> selected="selected"<?php }?>>Disabled</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Contact Details Form</th>
					<td>
						<select id="take_details" name="take_details">
							<option value="no"<?php if ( !isset($surveyDetails['take_details']) ||  $surveyDetails['take_details'] == 'no' ){?> selected="selected"<?php }?>>No</option>
							<option value="yes"<?php if ( isset($surveyDetails['take_details']) && $surveyDetails['take_details'] == 'yes' ){?> selected="selected"<?php }?>>Yes</option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
		
		<p class="submit">
			<input class="button-primary" type="submit" name="Save" value="Save Survey" id="submitbutton" />
		</p>
		
	</form>
	
</div>	