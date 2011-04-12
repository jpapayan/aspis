<?php
	$mark = ( !isset($_GET['mark']) || !ctype_digit($_GET['mark']) ) ? 0 : intval($_GET['mark']);
	
?>(function($) {
jQuery(document).ready( function(){
	
	var total = <?php echo $mark; ?>;
		
	$('.mark').change( function(){
		var newTotal = total;
		$('.mark').each(function() {
			newTotal += parseInt($(this).val());	
		});
		$('#total_points').html(newTotal);
		$('#overall_mark').val(newTotal);
	 });
	 
	 $('.show_hide_hint').click( function() {
	 		
	 		$(this).parent().next().toggle();
	 		return false;
	  } ).click();
	  
}); })(jQuery);	