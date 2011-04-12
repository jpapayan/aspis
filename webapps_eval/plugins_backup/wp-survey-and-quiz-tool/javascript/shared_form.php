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
	// Start add new row
	jQuery('#add_field').click( function(){

		rowCount++;
		
		// New row HTML
		var html = '<tr>';
		html += '<td><input type="text" name="field_name[]" value="" /></td>';
		html += '<td><select name="field_type[]">';
		html += '<option value="text">Text</option>';
		html += '<option value="textarea">Textarea</option>';
		html += '</select></td>';
		html += '<td><select name="field_required[]">';
		html += '<option value="no">No</option>';
		html += '<option value="yes">Yes</option>';
		html += '</select></td>';
		html += '</tr>';
		
		jQuery('#multi_table tr:last').after(html);
		return false;
	});

});