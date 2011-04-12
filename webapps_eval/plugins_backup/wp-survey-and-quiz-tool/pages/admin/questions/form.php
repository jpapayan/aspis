<?php 
if ( !isset($rowCount) ){ 
	$rowCount = 1;
}
?>
<script type="text/javascript" src="<?php echo bloginfo('wpurl'); ?>/wp-content/plugins/wp-survey-and-quiz-tool/javascript/question_form.php?rowcount=<?php echo $rowCount; ?>"></script>

<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Questions</h2>
	
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
					<td><input id="question" maxlength="255" size="50" name="question" value="<?php echo stripcslashes($questionText); ?>" /></td>
				</tr>
				<tr>
					<th scope="row">Question Type</th>
					<td>
						<select name="type" id="type">
							<option value="textarea"<?php if ( !isset($questionType) ||  $questionType == 'textarea' ){?> selected="selected"<?php }?>>Textarea</option>
							<option value="single"<?php if ( isset($questionType) &&  $questionType == 'single' ){?> selected="selected"<?php }?>>Single - Multiple Choice</option>
							<option value="multiple"<?php if ( isset($questionType) && $questionType == 'multiple' ){?> selected="selected"<?php }?>>Multiple - Multiple Choice</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Points</th>
					<td>
						<select name="points">
							<option value="1"<?php if ( !isset($questionValue) || $questionValue == 1){?> selected="yes"<?php }?>>1</option>
							<option value="2"<?php if ( isset($questionValue) && $questionValue == 2){?> selected="yes"<?php }?>>2</option>
							<option value="3"<?php if ( isset($questionValue) && $questionValue == 3){?> selected="yes"<?php }?>>3</option>
							<option value="4"<?php if ( isset($questionValue) && $questionValue == 4){?> selected="yes"<?php }?>>4</option>
							<option value="5"<?php if ( isset($questionValue) && $questionValue == 5){?> selected="yes"<?php }?>>5</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Difficulty</th>
					<td>
						<select name="difficulty">
							<option value="easy"<?php if ( isset($questionDifficulty) && $questionDifficulty == 'easy'){?> selected="yes"<?php }?>>Easy</option>
							<option value="medium"<?php if ( isset($questionDifficulty) && $questionDifficulty == 'medium'){?> selected="yes"<?php }?>>Medium</option>
							<option value="hard"<?php if ( isset($questionDifficulty) && $questionDifficulty == 'hard'){?> selected="yes"<?php }?>>Hard</option>
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
				<tr>
					<th scope="row">Additional Text</th>
					<td>
						<textarea name="additional" cols="40" rows="6"><?php if ( isset($questionAdditional) ){ echo $questionAdditional; } ?></textarea>
					</td>
				</tr>
				<tr class="additional"<?php if ( isset($answers) ) { ?> style="display: none;"<?php } ?>>
					<th scope="row">Answer Hint</th>
					<td>
						<textarea name="hint" cols="40" rows="6"><?php if ( isset($questionHint) ){  echo $questionHint; } ?></textarea>
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
						<th>Correct</th>
					</tr>
				</thead>
				<tbody>
					<?php if ( !isset($answers)  ) { ?>
					<tr>
						<td><input type="text" name="answer[0]" value="" size="30" id="answer_1" /></td>
						<td>
							<select name="correct[0]" id="correct_1">
								<option></option>
								<option value="no">No</option>
								<option value="yes">Yes</option>
							</select>
						</td>
					</tr>								
					<?php
						}
						else{ 
						 	foreach( $answers as $row => $answer ) { ?>
					<tr>
						<td><input type="text" name="answer[<?php echo $row; ?>]" value="<?php echo stripslashes($answer['text']); ?>" size="30" id="answer_1" /></td>
						<td>
							<select name="correct[<?php echo $row; ?>]" id="correct_1">
								<option></option>
								<option value="no"<?php if ($answer['correct'] == "no"){ ?> selected="selected"<?php } ?>>No</option>
								<option value="yes"<?php if ($answer['correct'] == "yes"){ ?> selected="selected"<?php } ?>>Yes</option>
							</select>
						</td>
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
	
	<h3>Help</h3>
	
	<a name="question_type"></a>
	<h4>Question Type</h4>
	
	<p>
		<ul>
			<li><strong>Single - Multiple Choice</strong> - A multiple choice question, where there is only one correct answer. <em>Automarking abled</em>.</li>
			<li><strong>Mutliple - Multiple Choice</strong> - A multiple choice question, where there can be more than one correct answer. <em>Automarking abled</em>.</li>
			<li><strong>Textarea</strong> - A question where the user is required to type an answer. <em>Can't be automarked</em>.</li>
		</ul>
	</p>
	
	<a name="additional_text"></a>
	<h4>Additional Text</h4>
	
	<p>An optional section of text where more detail can be given. HTML can be used in this area.</p>
	
	<a name="answer_hint"></a>
	<h4>Answer Hint</h4>
	
	<p>An optional section of text that is only displayed to users in wp-admin upon marking an exam.</p>
	
	<a name="question_value"></a>
	<h4>Question Value</h4>
	
	<p>Number of points a question is worth.</p>
	
</div>