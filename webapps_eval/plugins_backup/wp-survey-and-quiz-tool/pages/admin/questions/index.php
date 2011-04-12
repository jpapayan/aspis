<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Questions</h2>
	
	<div class="tablenav">
		<?php if ( isset($_GET['quizid']) ){ ?>
		<div class="alignleft">
			<a href="admin.php?page=<?php echo WPSQT_PAGE_QUESTIONS; ?>&action=addnew&quizid=<?php echo $_GET['quizid']; ?>" class="button-secondary" title="Add New Question">Add New Question</a>
		</div>
		<?php } ?>		
		<div class="tablenav-pages">
		   <?php echo wpsqt_functions_pagenation_display($currentPage, $numberOfPages); ?>
		</div>
	</div>
	
	<table class="widefat">
		<thead>
			<tr>
				<th>ID</th>
				<th>Question</th>
				<th>Type</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Question</th>
				<th>Type</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</tfoot>
		<tbody>
			<?php if ( empty($questions) ) { ?>			
				<tr>
					<td colspan="5"><div style="text-align: center;">No questions yet!</div></td>
				</tr>
			<?php }
				  else {
				  	
					foreach ($questions as $question) { ?>
			<tr>
				<td><?php echo $question['id']; ?></td>
				<td><?php echo stripslashes($question['text']); ?></td>
				<td><?php echo ucfirst( stripslashes($question['type']) ); ?></td>
				<td><a href="admin.php?page=<?php echo WPSQT_PAGE_QUESTIONS; ?>&action=edit&quizid=<?php echo $question['quizid']; ?>&id=<?php echo $question['id']; ?>" class="button-secondary" title="Edit Question">Edit</a></td>
				<td><a href="admin.php?page=<?php echo WPSQT_PAGE_QUESTIONS; ?>&action=delete&quizid=<?php echo $question['quizid']; ?>&id=<?php echo $question['id']; ?>" class="button-secondary" title="Delete Question">Delete</a></td>
			</tr>
			<?php } 
				 }?>
		</tbody>
	</table>

	<div class="tablenav">
		<?php if ( isset($_GET['quizid']) ){ ?>
		<div class="alignleft">
			<a href="admin.php?page=<?php echo WPSQT_PAGE_QUESTIONS; ?>&action=addnew&quizid=<?php echo $_GET['quizid']; ?>" class="button-secondary" title="Add New Question">Add New Question</a>
		</div>
		<?php } ?>		
		<div class="tablenav-pages">
		   <?php echo wpsqt_functions_pagenation_display($currentPage, $numberOfPages); ?>
		</div>		
	</div>

</div>