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
	var questionType = 'scale';
	
	// Start type change
	jQuery('#type').change( function(){ 
		
		questionType = jQuery('#type option:selected').val();
		
		if ( questionType == 'scale' ){
			jQuery('#multi_form').hide();
		}
		else {
			jQuery('#multi_form').show();
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
		html += '</tr>';
		
		jQuery('#multi_table tr:last').after(html);
		return false;
	});
	// End add new row
	
});