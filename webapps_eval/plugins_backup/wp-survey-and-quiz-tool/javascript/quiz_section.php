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
	jQuery('#add_section').click( function(){

		
		// New row HTML
		var html = '';
		html += '<tr>';
		html += '\t<td><input type="text" name="section_name['+rowCount+']" value="" size="30" id="name_'+rowCount+'" /></td>';
		html += '\t<td>';
		html += '\t\t<select name="type['+rowCount+']" id="type_'+rowCount+'">';
		html += '\t\t\t<option></option>';
		html += '\t\t\t<option value="multiple">Multiple Choice</option>';
		html += '\t\t\t<option value="textarea">Text input</option>';
		html += '\t\t</select>';
		html += '\t</td>';
		html += '\t<td>';
		html += '\t\t<select name="difficulty['+rowCount+']" id="difficulty_'+rowCount+'">';
		html += '\t\t\t<option></option>';
		html += '\t\t\t<option value="easy">Easy</option>';
		html += '\t\t\t<option value="medium">Medium</option>';
		html += '\t\t\t<option value="hard">Hard</option>';
		html += '\t\t\t<option value="mixed">Mixed</option>';
		html += '\t\t</select>';
		html += '\t</td>';
		html += '\t<td><input type="text" name="number['+rowCount+']" value="" size="10" id="number_'+rowCount+'" /></td>';
		html += '\t	<td>';
		html += '\t\t<select name="order['+rowCount+']">';
		html += '\t\t\t<option value="random">Random</option>';
		html += '\t\t\t<option value="asc">Ascending</option>';
		html += '\t\t\t<option value="desc">Descending</option>';
		html += '\t\t\t</select>';
		html += '\t\t\t</td>';
		html += '</tr>';
		
		rowCount++;
		jQuery('#section_table tr:last').after(html);
		return false;
	});
	// End add new row

});