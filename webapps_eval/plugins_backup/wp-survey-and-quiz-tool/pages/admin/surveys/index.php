<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>
		WP Survey And Quiz Tool - Surveys
	</h2>
	
	<div class="tablenav">
		<div class="alignleft">
			<a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=create" class="button-secondary" title="Add New Quiz">Add New Quiz</a>
		</div>
	
		<div class="tablenav-pages">
		   <?php echo wpsqt_functions_pagenation_display($currentPage, $numberOfPages); ?>
		</div>
	</div>
	
	<table class="widefat">
		<thead>
			<tr>
				<th>ID</th>
				<th>Survey Name</th>
				<th>Overall Result</th>
				<th>Results List</th>
				<th>Edit Questions</th>
				<th>Edit Sections</th>
				<th>Edit Form</th>
				<th>Configure</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Survey Name</th>
				<th>Overall Result</th>
				<th>Results List</th>
				<th>Edit Questions</th>
				<th>Edit Sections</th>
				<th>Edit Form</th>
				<th>Configure</th>
				<th>Delete</th>
			</tr>
		</tfoot>
		<tbody>
			
			<?php
			if ( empty($surveyList) ){
				?>
				<tr>
					<td colspan="7"><div style="text-align: center;">No surveys yet!</div></td>
				</tr>
				<?php 
			}
			else {
				foreach ( $surveyList as $survey ) { ?>
			<tr>
				<td><?php echo $survey['id']; ?></td>
				<td><?php echo stripslashes($survey['name']); ?></td>
				<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=view-total&surveyid=<?php echo $survey['id']; ?>" class="button-secondary" title="Overall Result">Overall Result</a></td>
				<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=list-results&surveyid=<?php echo $survey['id']; ?>" class="button-secondary" title="Single Results">Single Results</a></td>
				<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=questions&surveyid=<?php echo $survey['id']; ?>" class="button-secondary" title="Edit Questions">Edit Questions</a></td>
				<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=sections&surveyid=<?php echo $survey['id']; ?>" class="button-secondary" title="Edit Questions">Edit Sections</a></td>
				<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=forms&surveyid=<?php echo $survey['id']; ?>" class="button-secondary" title="Edit Form">Edit Form</a></td>
				<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=configure&surveyid=<?php echo $survey['id']; ?>" class="button-secondary" title="Configure Survey">Configure Survey</a></td>
				<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=delete&surveyid=<?php echo $survey['id']; ?>" class="button-secondary" title="Delete Quiz">Delete</a></td>
			</tr>
			<?php } 
				}?>
		</tbody>
	</table>
	
	<div class="tablenav">
		<div class="alignleft">
			<a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=create" class="button-secondary" title="Add New Quiz">Add New Quiz</a>
		</div>
	
		<div class="tablenav-pages">
		   <?php echo wpsqt_functions_pagenation_display($currentPage, $numberOfPages); ?>
		</div>
	</div>
</div>