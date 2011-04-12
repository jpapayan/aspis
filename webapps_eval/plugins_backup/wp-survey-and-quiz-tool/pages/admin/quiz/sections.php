<?php 
if ( isset($redirectUrl) ){
?>
<script type="text/javascript">
window.location = "<?php echo $redirectUrl; ?>";
</script>
<?php 
	exit;
}


if ( !isset($rowCount) ){ 
	$rowCount = 1;
}

if ( empty($validData) ){
	$validData = array(array('name' => '', 'difficulty' => 'medium', 'type' => '', 'number' => '','orderby' => ''));
}
?>
<script type="text/javascript" src="<? echo bloginfo('wpurl'); ?>/wp-content/plugins/wp-survey-and-quiz-tool/javascript/quiz_section.php?rowcount=<?php echo sizeof($validData); ?>"></script>

<div class="wrap">


	<?php if ( isset($successMessage) ) {?>
		<div class='updated'><?php echo $successMessage; ?></div>
				
	<?php } ?>
	<div id="icon-tools" class="icon32"></div>
	<h2>
		WP Survey And Quiz Tool - Quiz Sections
	</h2>
	
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
						<th>Difficulty</th>
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
								<option value="textarea"<?php if ($data['type'] == 'textarea'){?> selected="yes"<?php }?>>Text input</option>
							</select>
						</td>
						<td>
							<select name="difficulty[<?php echo $key; ?>]" id="difficulty_<?php echo $key; ?>">
								<option></option>
								<option value="easy"<?php if ($data['difficulty'] == 'easy'){?> selected="yes"<?php }?>>Easy</option>
								<option value="medium"<?php if ($data['difficulty'] == 'medium'){?> selected="yes"<?php }?>>Medium</option>
								<option value="hard"<?php if ($data['difficulty'] == 'hard'){?> selected="yes"<?php }?>>Hard</option>
								<option value="mixed"<?php if ($data['difficulty'] == 'mixed'){?> selected="yes"<?php }?>>Mixed</option>
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
	<h4>Difficulty Meanings</h4>
	
	<ul>
		<li><strong>Easy</strong> - All questions will be ranked as easy</li>
		<li><strong>Medium</strong> - All questions will be ranked as medium - Suggested</li>
		<li><strong>Hard</strong> - All questions will be ranked as hard</li>
		<li><strong>Mixed</strong> - An even number of questions from all sections, unless total number of questions is not dividable by 3. Then it will random which difiiculty gets the most/least.</li>
	</ul>
	
	<h4>Type Meanings</h4>

	<ul>
		<li><strong>Multiple Choice</strong> - Displays questions that are multiple choice both multiple and single correct answers. <strong>Has automarking</strong></li>
		<li><strong>Text Input</strong>  - Displays questions that require text input by the user. <strong>No automarking.</strong></li>
	</ul>
</div>