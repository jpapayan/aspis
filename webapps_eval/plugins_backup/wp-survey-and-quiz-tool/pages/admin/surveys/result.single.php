<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Survey Result</h2>
	
	
	<?php if (!empty($result['person'])) { ?>
		<h3>User Details</h3>
		<div class="person">
			<ul>
				<li><b><u>Name</u></b> - <?php echo htmlentities(strip_tags(stripslashes($result['person']['name']))); ?></li>
				<li><b><u>Email</u></b> - <?php echo htmlentities(strip_tags(stripslashes($result['person']['email']))); ?></li>
				<li><b><u>Phone</u></b> - <?php echo htmlentities(strip_tags(stripslashes($result['person']['phone']))); ?></li>
				<li><b><u>Heard Of</u></b> - <?php echo htmlentities(strip_tags(stripslashes($result['person']['heard']))); ?></li>
				<li><b><u>IP Address</u></b> - <?php echo $result['ipaddress']; ?></li>
				<li><b><u>Hostname</u></b> - <?php echo gethostbyaddr($result['ipaddress']); ?></li> 
				<li><b><u>Address</u></b> - <?php echo nl2br(htmlentities(strip_tags(stripslashes($result['person']['address'])))); ?></li>
				<li><b><u>Notes</u></b> - <?php echo nl2br(htmlentities(strip_tags(stripslashes($result['person']['notes'])))); ?></li>
			</ul>
		</div>
	<?php } ?>
	
	<?php foreach ( $result['results'] as $section ){ ?>
		<h3><?php echo $section['name']; ?></h3>
		
		<?php foreach ($section['questions'] as $questionKey => $questionArray){ ?>
			<h4><?php print stripslashes($questionArray['text']); ?></h4>
			
			<?php if ($section['type'] == 'multiple'){ 	?>
			<ul>
			<?php foreach ($questionArray['answers'] as $answer){ ?>
				<li><font color="<?php echo ( $questionArray['answer'] == $answer['id'] ) ? '#00FF00' :  '#000000' ; ?>"><?php echo stripslashes($answer['text']) ?></font></li>
			<?php } ?>
				<li><font color="<?php echo ( $questionArray['answer'] == 0 ) ? '#00FF00' :  '#000000' ; ?>">Other <?php if ($questionArray['answer']  == '0'){ echo '- '.htmlentities(strip_tags(stripslashes($questionArray['answer_other']))); } ?></font></li>
			</ul>
			<?php } else { ?>
				Answer : <?php echo $questionArray['answer']; ?>
			<?php } ?>
	   <?php } ?>
	<?php } ?>

</div>