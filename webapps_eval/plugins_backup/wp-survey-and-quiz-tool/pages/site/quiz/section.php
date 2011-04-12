<h1><?php echo $_SESSION['wpsqt'][$quizName]['quiz_sections'][$sectionKey]['name']; ?></h1>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<input type="hidden" name="step" value="<?php echo ( $_SESSION['wpsqt']['current_step']+1); ?>">
<?php foreach ($_SESSION['wpsqt'][$quizName]['quiz_sections'][$sectionKey]['questions'] as $question) { ?>
	
	<div class="wpst_question">
		<?php echo stripslashes($question['text']);
		
			if ( !empty($question['additional']) ){
			?>
			<p><?php echo $question['additional']; ?></p>
			<?php } ?>
		
		<?php if ($question['type'] != 'textarea' && isset($question['answers']) ){?>
			<ul>
			<?php foreach ( $question['answers'] as $answer ){ ?>
				<li>
					<input type="<?php echo ($question['type'] == 'single') ? 'radio' : 'checkbox'; ?>" name="answers[<?php echo $question['id']; ?>][]" value="<?php echo $answer['id']; ?>" id="answer_<?php echo $question['id']; ?>_<?php echo $answer['id'];?>"> <label for="answer_<?php echo $question['id']; ?>_<?php echo $answer['id'];?>"><?php echo stripslashes($answer['text']); ?></label> 
				</li>
			<?php } ?>
			</ul>
		<?php } else { ?>
		<p><textarea rows="6" cols="50" name="answers[<?php echo $question['id']; ?>][]"></textarea></p>
		<?php }?>	
	</div>
<?php } ?>

	<p><input type='submit' value='Next &raquo;' class='button-secondary' /></p>
</form>
