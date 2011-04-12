<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Survey Results</h2>
	<?php foreach ( $surveyArray['multiple'] as $result ){ ?>
		<?php 
			$question      = current($result);
			$googleChartUrl = 'http://chart.apis.google.com/chart?chs=293x185&cht=p';
			$valueArray    = array();
			$nameArray     = array();
		?>
		<h3><?php echo $question['question']; ?></h3>
		<?php
		foreach( $result as $answer ){ 
			$valueArray[] = $answer['total'];
			$nameArray[] = $answer['answer'].' - '.$answer['total'];	 
		}
		 
		$googleChartUrl .= '&chd=t:'.implode(',', $valueArray);
		$googleChartUrl .= '&chdl='.implode('|',$nameArray);
		$googleChartUrl .= '&chtt='.$question['question'];
		 ?>
		 
		 <img src="<?php echo $googleChartUrl; ?>" alt="<?php echo $question['text']; ?>" />
		 		 
	<?php } ?>
	
	<?php foreach( $surveyArray['scale'] as $question ) { ?>
		<h3><?php echo $question['question']; ?></h3>
		<strong>Average</strong> : <?php echo (int)$question['total']; ?><br />
		<strong>Total Votes</strong> : <?php echo $question['count']; ?>
		
		
	<?php } ?>
</div>	