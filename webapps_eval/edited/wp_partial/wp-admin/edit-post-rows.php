<?php require_once('AspisMain.php'); ?><?php
if ( !defined('ABSPATH'))
 exit('-1');
;
?>
<table class="widefat post fixed" cellspacing="0">
	<thead>
	<tr>
<?php print_column_headers('edit');
;
?>
	</tr>
	</thead>

	<tfoot>
	<tr>
<?php print_column_headers('edit',false);
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