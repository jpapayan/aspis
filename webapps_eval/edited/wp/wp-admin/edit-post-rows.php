<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('ABSPATH')))))
 Aspis_exit(array('-1',false));
;
?>
<table class="widefat post fixed" cellspacing="0">
	<thead>
	<tr>
<?php print_column_headers(array('edit',false));
;
?>
	</tr>
	</thead>

	<tfoot>
	<tr>
<?php print_column_headers(array('edit',false),array(false,false));
;
?>
	</tr>
	</tfoot>

	<tbody>
<?php post_rows();
;
?>
	</tbody>
</table><?php 