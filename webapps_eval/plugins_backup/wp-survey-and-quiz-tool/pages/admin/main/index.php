<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool</h2>

	<h3>Last Ten Results</h3>

	<table class="widefat">
		<thead>
			<tr>
				<th>ID</th>
				<th>Quiz</th>
				<th>Name</th>
				<th>IP</th>
				<th>Timestamp</th>
				<th>Current Status</th>
				<th>Mark</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Quiz</th>
				<th>Name</th>
				<th>IP</th>
				<th>Timestamp</th>
				<th>Current Status</th>
				<th>Mark</th>
				<th>Delete</th>
			</tr>
		</tfoot>
		<tbody>
			<?php 
				if ( empty($results) ){
					?><tr>
						<td colspan="8"><center><?php _e( 'No new results to be marked!' , 'wp-survey-and-quiz-tool' ); ?></center></td>
					  </tr>
					<?php 
				}
				else{
					
					foreach($results as $result){ ?>
			<tr>
				<td><?php echo $result['id']; ?></td>
				<td><?php echo $result['name']; ?></td>
				<td><?php echo htmlentities($result['person_name']); ?></td>
				<td><?php echo $result['ipaddress']; ?></td>
				<td><?php echo $result['timestamp']; ?></td>
				<td><?php echo $result['status']; ?></td>
				<td><a href="admin.php?page=<?php echo WPSQT_PAGE_QUIZ_RESULTS; ?>&action=mark&resultid=<?php echo $result['id']; ?>" class="button-secondary">Mark</a></td>
				<td><a href="admin.php?page=<?php echo WPSQT_PAGE_QUIZ_RESULTS; ?>&action=delete&resultid=<?php echo $result['id']; ?>" class="button-secondary">Delete</a></td>
			</tr>
			<?php 	}
				} ?>
		</tbody>
	</table>
	
	<h3>Five newest Quizes</h3>
	
	<table class="widefat">
		<thead>
			<tr>
				<th>ID</th>
				<th>Quiz Name</th>
				<th>Status</th>
				<th>Type</th>
				<th>Edit Questions</th>
				<th>Edit Sections</th>
				<th>Configure</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Quiz Name</th>
				<th>Status</th>
				<th>Type</th>
				<th>Edit Questions</th>
				<th>Edit Sections</th>
				<th>Configure</th>
				<th>Delete</th>
			</tr>
		</tfoot>
		<tbody>
			
			<?php
			if ( !isset($quizList) || empty($quizList) ){
				?>
				<tr>
					<td colspan="7"><div style="text-align: center;">No quizes or surveys yet!</div></td>
				</tr>
				<?php 
			}
			else {
				foreach ( $quizList as $quiz ) { ?>
			<tr>
				<td><?php echo $quiz['id']; ?></td>
				<td><?php echo stripslashes($quiz['name']); ?></td>
				<td><?php echo ucfirst( stripslashes($quiz['status']) ); ?></td>
				<td><?php echo ucfirst( stripslashes($quiz['type']) ); ?></td>
				<td><a href="admin.php?page=<?php echo WPSQT_PAGE_QUESTIONS; ?>&action=list&quizid=<?php echo $quiz['id']; ?>" class="button-secondary" title="Edit Questions">Edit Questions</a></td>
				<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=sections&quizid=<?php echo $quiz['id']; ?>" class="button-secondary" title="Edit Questions">Edit Sections</a></td>
				<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=configure&quizid=<?php echo $quiz['id']; ?>" class="button-secondary" title="Configure Quiz">Configure Quiz</a></td>
				<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=delete&quizid=<?php echo $quiz['id']; ?>" class="button-secondary" title="Delete Quiz">Delete</a></td>
			</tr>
			<?php } 
				}?>
		</tbody>
	</table>


</div> 