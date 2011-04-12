<h2>Exam Finished</h2>

<?php if ($_SESSION['wpsqt'][$quizName]['quiz_details']['display_result'] == 'no') { ?>
Thank you for your time..
<?php } elseif ($canAutoMark === true) { ?>
You got <?php echo $correctAnswers; ?> correct out of <?php echo $totalQuestions; ?>. 
<?php } else { ?>
Can't auto mark this.
<?php } ?>