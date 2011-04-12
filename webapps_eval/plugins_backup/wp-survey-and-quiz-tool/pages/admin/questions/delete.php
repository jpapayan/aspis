<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>PHP Test - Questions</h2>

	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<p style="text-align: center;">Are you sure you want to delete the "<em><?php echo stripslashes($questionText); ?></em>" question?</p>
		<p style="text-align: center;"><input type="submit" name="confirm" value="Yes" class='button-secondary' /></p>
	</form>
	
</div>