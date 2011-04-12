<?php 
if ( !isset($rowCount) ){ 
	$rowCount = 1;
}
?>
<script type="text/javascript" src="<?php echo bloginfo('wpurl'); ?>/wp-content/plugins/wp-survey-and-quiz-tool/javascript/survey_question.php?rowcount=<?php echo $rowCount; ?>"></script>

<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Survey Questions</h2>
	
	<?php if ( isset($successMessage) ){ ?>
		<div class="updated" id="question_added"><?php echo $successMessage; ?></div>
	<?php } ?>
	
	<?php if ( !empty($errorArray) ){ ?>
		<div class="error">
			<ul>
				<?php foreach ( $errorArray as $error ) { ?>
					<li><?php echo $error; ?></li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>
	
	<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="question_form">
		
		<input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>"  />
	
		<table class="form-table" id="question_form">
			<tbody>
				<tr>
					<th scope="row">Question</th>
					<td><input id="question" maxlength="255" size="50" name="question" value="<?php if ( isset($questionText) ){ echo stripcslashes($questionText); } ?>" /></td>
				</tr>
				<tr>
					<th scope="row">Question Type</th>
					<td>
						<select name="type" id="type">
							<option value="scale"<?php if ( !isset($questionType) ||  $questionType == 'scale' ){?> selected="selected"<?php }?>>Scale</option>
							<option value="multiple"<?php if ( isset($questionType) && $questionType == 'multiple' ){?> selected="selected"<?php }?>>Multiple Choice</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Section</th>
					<td><select name="section">
							<?php foreach($sections as $section) {?>
							<option value="<?php echo $section['id']; ?>" <?php if ( isset($sectionId) && $sectionId == $section['id']) { ?> selected="yes"<?php } ?>><?php echo $section['name']; ?></option>
							<?php } ?>
					</select>
					</td>
				</tr>
			</tbody>
		</table>
		
		<div id="multi_form"<?php if ( !isset($answers) ) { ?> style="display: none;"<?php } ?>>
		
		<h3>Choices</h3>
		
			<table class="form-table" id="multi_table" >
				<thead>
					<tr>
						<th>Answer</th>
					</tr>
				</thead>
				<tbody>
					<?php if ( !isset($answers)  ) { ?>
					<tr>
						<td><input type="text" name="answer[0]" value="" size="30" /></td>
						
					</tr>								
					<?php
						}
						else{ 
						 	foreach( $answers as $row => $answer ) { ?>
					<tr>
						<td><input type="text" name="answer[<?php echo $row; ?>]" value="<?php echo stripslashes($answer['text']); ?>" size="30" /></td>
					</tr>
						<?php							
						 	}
						} ?>
				</tbody>
			</table>
			
			<p><a href="#" class="button-secondary" title="Add New Answer" id="add_answer">Add New Answer</a></p>
			
		</div>
	
		<p class="submit">
			<input class="button-primary" type="submit" name="Save" value="Save Question" id="submitbutton" />
		</p>
		
	</form>
	
</div>