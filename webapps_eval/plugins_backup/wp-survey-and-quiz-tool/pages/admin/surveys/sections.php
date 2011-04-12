<?php 
if ( isset($redirectUrl) ){
?>
<script type="text/javascript">
window.location = "<?php echo $redirectUrl; ?>";
</script>
<?php 
	exit;
}

if ( empty($validData) ){
	$validData = array(array('name' => '', 'difficulty' => '', 'type' => '', 'number' => '','orderby' => ''));
}
?>
<script type="text/javascript" src="/wp-content/plugins/wp-survey-and-quiz-tool/javascript/survey_section.php?rowcount=<?php echo sizeof($validData); ?>"></script>

<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>
		WP Survey And Quiz Tool - Survey Sections
	</h2>
	
	<?php if ( isset($successMessage) ) {?>
		<div class='updated'><?php echo $successMessage; ?></div>
				
	<?php } ?>
	
	<?php if ( isset($errorArray) && !empty($errorArray) ) { ?>
		<ul class="error">
			<?php foreach($errorArray as $error ){ ?>
				<li><?php echo $error; ?></li>
			<?php } ?>
		</ul>
	<?php } ?>
	<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="section_form">
	
		<table class="form-table" id="section_table" >
				<thead>
					<tr>
						<th>Name</th>
						<th>Type</th>
						<th>Number Of Questions</th>
						<th>Order Of Questions</th>
					</tr>
				</thead>
				<tbody>	
					<?php foreach ($validData as $key => $data) {?>			
					<tr>
						<td>							
							<input type="hidden" name="sectionid[<?php echo $key; ?>]" value="<?php echo $data['id']; ?>" />
							<input type="text" name="section_name[<?php echo $key; ?>]" value="<?php echo $data['name']; ?>" size="30" id="name_<?php echo $key; ?>" />
						</td>
						<td>
							<select name="type[<?php echo $key; ?>]" id="type_<?php echo $key; ?>">
								<option></option>
								<option value="multiple"<?php if ($data['type'] == 'multiple'){?> selected="yes"<?php }?>>Multiple Choice</option>
								<option value="scale"<?php if ($data['type'] == 'scale'){?> selected="yes"<?php }?>>Scale</option>
							</select>
						</td>
						<td><input type="text" name="number[<?php echo $key; ?>]" value="<?php echo $data['number']; ?>" size="10" id="number_<?php echo $key; ?>" /></td>
						<td>
							<select name="order[<?php echo $key; ?>]">
								<option value="random"<?php if ($data['orderby'] == 'random'){?> selected="yes"<?php }?>>Random</option>
								<option value="asc"<?php if ($data['orderby'] == 'asc'){?> selected="yes"<?php }?>>Ascending</option>
								<option value="desc"<?php if ($data['orderby'] == 'desc'){?> selected="yes"<?php }?>>Descending</option>
							</select>
						</td>
					</tr>
					<?php } ?>
				</tbody>
		</table>
	
		<p><a href="#" class="button-secondary" title="Add New Section" id="add_section">Add Section</a></p>
			
		<p class="submit">
			<input class="button-primary" type="submit" name="Save" value="Save" id="submitbutton" />
		</p>
	</form>

		
	<a name="difficutly_def"></a>
	
	<h4>Type Meanings</h4>

	<ul>
		<li><strong>Multiple Choice</strong> - Displays options given aswell as a 'other' field which has a text input.</li>
		<li><strong>Scale</strong>  - Displays a question with a scale of 1 to 10 for users to select.</li>
	</ul>
</div>