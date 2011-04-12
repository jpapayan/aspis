<?php 
if (isset($_GET['rowcount'])){
	$rowCount = $_GET['rowcount'];
}
else{ 
	$rowCount = 1;
}
?>
jQuery(document).ready( function(){
	
	var rowCount = <?php echo $rowCount; ?>;
	var questionType = 'textarea';
	
	// Start type change
	jQuery('#type').change( function(){ 
		
		questionType = jQuery('#type option:selected').val();
		
		if ( questionType == 'textarea' ){
			jQuery('#multi_form').hide();
			jQuery('.additional').show();
		}
		else {
			jQuery('#multi_form').show();
			jQuery('.additional').hide();
		}
		
	});
	// End type change
	
	// Start add new row
	jQuery('#add_answer').click( function(){

		rowCount++;
		
		// New row HTML
		var html = '';		
		html += '<tr>\n';
		html += '\t<td><input type="text" name="answer[]" value="" size="30" id="answer_'+rowCount+'" /></td>\n';
		html += '\t<td>\n'
		html += '\t\t<select name="correct[]" id="correct_'+rowCount+'">\n';
		html += '\t\t<option></option>';
		html += '\t\t<option value="no">No</option>';
		html += '\t\t<option value="yes">Yes</option>';
		html += '\t\t</select>';
		html += '\t</td>';
		html += '</tr>';
		
		jQuery('#multi_table tr:last').after(html);
		return false;
	});
	// End add new row

	jQuery('#submitbutton').click( function(){
		
		if ( questionType == 'textarea' ){
			return true;
		}
		
		//
		var answerCount = 0;
		var correctCount = 0;
		
		for ( var i = 1; i <= rowCount; i++ ){
			
			var answer = jQuery('#answer_'+i).val();
			var correct = jQuery('#correct_'+i).val();
			
			if ( answer != '' ){
				answerCount++;
			}			
			if ( correct == 'yes' ){
				correctCount++;
			}
			
		}
		
		if ( answerCount == 0  ){
			alert('Require at least one answer');
			return false;
		}
		
		if ( correctCount == 0 ){
			alert('Require at least one correct answer');
			return false;
		}		
		if ( correctCount > 1 && questionType == 'single' ){
			alert('There can only be one correct answer for this multiple choice');
			return false;
		}
		
		return true;
	});
	
});