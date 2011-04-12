<h1><?php echo $_SESSION['wpsqt'][$surveyName]['survey_sections'][$sectionKey]['name']; ?></h1>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<input type="hidden" name="step" value="<?php echo ($_SESSION['wpsqt']['current_step']+1); ?>">
<?php foreach ($_SESSION['wpsqt'][$surveyName]['survey_sections'][$sectionKey]['questions'] as $questionKey => $question) { ?>
	
	<div class="wpst_question">
		<?php echo stripslashes($question['text']); ?>
		
		<?php if ($question['type'] == 'multiple' && isset($question['answers']) ){?>
			<ul>
			<?php foreach ( $question['answers'] as $answer ){ ?>
				<li>
					<input type="radio" name="answers[<?php echo $questionKey; ?>]" value="<?php echo $answer['id']; ?>" id="answer_<?php echo $question['id']; ?>_<?php echo $answer['id']; ?>"> <label for="answer_<?php echo $question['id']; ?>_<?php echo $answer['id'];?>"><?php echo stripslashes($answer['text']); ?></label> 
				</li>
			<?php } ?>
				<li>
					<input type="radio" name="answers[<?php echo $questionKey; ?>]" value="0" id="answer_<?php echo $question['id']; ?>_other"> <label for="answer_<?php echo $question['id']; ?>_other">Other</label> <input type="text" name="other[<?php echo $questionKey; ?>]" value="" />
				</li>
			</ul>
		<?php } else { ?>
		<p>
			<?php for ( $i = 1; $i <= 10; $i++){ ?>
			<input type="radio" name="answers[<?php echo $questionKey; ?>]" value="<?php echo $i; ?>" id="answer_<?php echo $question['id']; ?>_<?php echo $i; ?>" /> <label for="answer_<?php echo $question['id']; ?>_<?php echo $i; ?>"><?php echo $i; ?></label> 
			<?php }?>
		<?php }?>	
	</div>
<?php } ?>

	<p><input type='submit' value='Next &raquo;' class='button-secondary' /></p>
</form>
