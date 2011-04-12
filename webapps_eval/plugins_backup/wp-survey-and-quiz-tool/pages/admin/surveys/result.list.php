<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Survey Results</h2>
	
	<div class="tablenav">
		<div class="alignleft">
			Showing results for <?php echo $showingResultsFor; ?>.
		</div>
			
		<div class="tablenav-pages">
		   <?php echo wpsqt_functions_pagenation_display($currentPage, $numberOfPages); ?>
		</div>
	</div>
	
	<table class="widefat">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Ip Adress</th>
				<th>View</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Ip Adress</th>
				<th>View</th>
			</tr>
		</tfoot>
		<tbody>
			<?php if ( empty($results) ) { ?>			
				<tr>
					<td colspan="4"><div style="text-align: center;">No results yet!</div></td>
				</tr>
			<?php }
				  else {
				  	
					foreach ($results as $result) { ?>
			<tr>
				<td><?php echo $result['id']; ?></td>
				<td><?php echo stripslashes($result['name']); ?></td>
				<td><?php echo stripslashes($result['ipaddress']); ?></td>
				<td><a href="admin.php?page=<?php echo WPSQT_PAGE_SURVEY; ?>&action=view-result&surveyid=<?php echo $surveyId; ?>&id=<?php echo $result['id']; ?>" class="button-secondary" title="View Result">View</a></td>
			</tr>
			<?php } 
				 }?>
		</tbody>
	</table>

	<div class="tablenav">
	
		<?php if (isset($surveyId)) {?>
		<div class="alignleft">
			 <a href="<?php echo $_SERVER['REQUEST_URI']; ?>&survey_csv=yes">Export as CSV</a>.
		</div>
		<?php } ?>
		
		<div class="tablenav-pages">
		   <?php echo wpsqt_functions_pagenation_display($currentPage, $numberOfPages); ?>
		</div>		
	</div>

</div>